<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use VercelBlobPhp\Client as VercelBlobClient;
use VercelBlobPhp\CommonCreateBlobOptions;

class MediaStorageService
{
    public function storeUploadedFile(UploadedFile $file, string $directory): string
    {
        if (! $this->shouldUseBlob()) {
            return $file->store($directory, 'public');
        }

        $token = (string) config('services.vercel_blob.token');
        $access = (string) config('services.vercel_blob.access', 'public');
        $client = new VercelBlobClient($token);

        $extension = strtolower((string) $file->getClientOriginalExtension());
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $baseName = $baseName !== '' ? $baseName : 'file';
        $finalName = Str::uuid()->toString() . '-' . $baseName;

        if ($extension !== '') {
            $finalName .= '.' . $extension;
        }

        $pathname = trim($directory, '/') . '/' . now()->format('Y/m') . '/' . $finalName;

        $result = $client->put(
            path: $pathname,
            content: fopen($file->getRealPath(), 'rb'),
            options: new CommonCreateBlobOptions(
                access: $access,
                addRandomSuffix: false,
                contentType: $file->getMimeType() ?: null
            )
        );

        return $result->url;
    }

    public function deleteFile(?string $pathOrUrl): void
    {
        if (! filled($pathOrUrl)) {
            return;
        }

        if (! $this->isUrl($pathOrUrl)) {
            Storage::disk('public')->delete($pathOrUrl);
            return;
        }

        if (! $this->shouldUseBlob() || ! $this->isVercelBlobUrl($pathOrUrl)) {
            return;
        }

        try {
            $token = (string) config('services.vercel_blob.token');
            $client = new VercelBlobClient($token);
            $client->del([$pathOrUrl]);
        } catch (Throwable $exception) {
            Log::warning('Gagal menghapus file dari Vercel Blob', [
                'file' => $pathOrUrl,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function shouldUseBlob(): bool
    {
        $enabled = (bool) config('services.vercel_blob.enabled', true);
        $token = (string) config('services.vercel_blob.token', '');

        return $enabled && $token !== '';
    }

    private function isUrl(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    private function isVercelBlobUrl(string $url): bool
    {
        $host = (string) parse_url($url, PHP_URL_HOST);

        return Str::endsWith($host, '.blob.vercel-storage.com');
    }
}
