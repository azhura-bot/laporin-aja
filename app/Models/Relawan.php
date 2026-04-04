<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;

    protected $table = 'relawans';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'no_hp',
        'domisili',
        'keahlian',
        'motivasi',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'Menunggu Verifikasi',
            'aktif' => 'Aktif',
            'nonaktif' => 'Tidak Aktif'
        ][$this->status] ?? 'Pending';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'aktif' => 'bg-green-100 text-green-800',
            'nonaktif' => 'bg-red-100 text-red-800'
        ];

        $color = $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
        
        return "<span class='px-2 py-1 rounded-full text-xs font-semibold {$color}'>{$this->status_text}</span>";
    }
}