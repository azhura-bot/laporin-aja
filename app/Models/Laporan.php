<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

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
        'user_id',
        'operator_id',
        'catatan_operator',
        'bukti_penanganan',
        'ditugaskan_at',
        'diproses_at',
        'selesai_at',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'ditugaskan_at' => 'datetime',
        'diproses_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Operator
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    // Relasi ke Tanggapan (ONE TO MANY)
    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class, 'laporan_id');
    }

    // Alias untuk tanggapans (agar bisa dipanggil dengan tanggapan)
    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'laporan_id');
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800'
        ];

        $color = $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
        $text = [
            'pending' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai'
        ][$this->status] ?? 'Tidak Diketahui';
        
        return "<span class='px-2 py-1 rounded-full text-xs font-semibold {$color}'>{$text}</span>";
    }

    // Accessor untuk lampiran URL
    public function getLampiranUrlAttribute()
    {
        if ($this->lampiran) {
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

    // Accessor untuk bukti penanganan URL
    public function getBuktiPenangananUrlAttribute()
    {
        if ($this->bukti_penanganan) {
            return asset('storage/' . $this->bukti_penanganan);
        }

        return null;
    }

    // Cek apakah bukti penanganan adalah gambar
    public function getIsBuktiPenangananImageAttribute()
    {
        if (!$this->bukti_penanganan) return false;

        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
        $extension = strtolower(pathinfo($this->bukti_penanganan, PATHINFO_EXTENSION));

        return in_array($extension, $extensions);
    }
}
