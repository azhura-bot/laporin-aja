<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan
     */
    protected $table = 'laporans';

    /**
     * Atribut yang boleh diisi secara massal (FILLABLE)
     */
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

    /**
     * Atribut yang harus di-cast ke tipe data tertentu
     */
    protected $casts = [
        'tanggal_kejadian' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor untuk status dalam format Indonesia
     */
    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'Menunggu',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai'
        ][$this->status] ?? 'Tidak Diketahui';
    }

    /**
     * Accessor untuk badge status dengan warna
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800'
        ];

        $color = $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
        
        return "<span class='px-2 py-1 rounded-full text-xs font-semibold {$color}'>{$this->status_text}</span>";
    }

    /**
     * Mendapatkan URL lengkap untuk lampiran
     */
    public function getLampiranUrlAttribute()
    {
        if ($this->lampiran) {
            return asset('storage/' . $this->lampiran);
        }
        return null;
    }

    /**
     * Cek apakah lampiran berupa gambar
     */
    public function getIsLampiranImageAttribute()
    {
        if (!$this->lampiran) return false;
        
        $extension = pathinfo($this->lampiran, PATHINFO_EXTENSION);
        return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }
}