<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelapor',
        'no_hp',
        'email',
        'kategori',
        'lokasi',
        'tanggal_kejadian',
        'judul_laporan',
        'deskripsi',
        'lampiran',
        'status',
        'user_id'
    ];

    protected $casts = [
        'tanggal_kejadian' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor untuk mendapatkan URL lengkap lampiran
    public function getLampiranUrlAttribute()
    {
        if ($this->lampiran) {
            // Cek apakah sudah ada storage path
            if (str_starts_with($this->lampiran, 'storage/')) {
                return asset($this->lampiran);
            }
            // Jika hanya nama file
            if (file_exists(public_path('storage/lampiran/' . $this->lampiran))) {
                return asset('storage/lampiran/' . $this->lampiran);
            }
            // Default storage path
            return asset('storage/' . $this->lampiran);
        }
        return null;
    }

    // Cek apakah lampiran adalah gambar
    public function getIsLampiranImageAttribute()
    {
        if (!$this->lampiran) return false;
        
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
        $extension = strtolower(pathinfo($this->lampiran, PATHINFO_EXTENSION));
        
        return in_array($extension, $extensions);
    }
    public function tanggapan()
{
    return $this->hasMany(Tanggapan::class);
}
}