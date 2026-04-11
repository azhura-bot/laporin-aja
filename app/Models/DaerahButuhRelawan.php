<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relawan;

class DaerahButuhRelawan extends Model
{
    use HasFactory;

    protected $table = 'daerah_butuh_relawan';

    protected $fillable = [
        'nama_daerah',
        'provinsi',
        'deskripsi',
        'prioritas',
        'relawan_dibutuhkan',
        'relawan_terdaftar',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'relawan_dibutuhkan' => 'integer',
        'relawan_terdaftar' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getPrioritasTextAttribute()
    {
        return [
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'kritis' => 'Kritis'
        ][$this->prioritas] ?? 'Sedang';
    }

    public function getPrioritasBadgeAttribute()
    {
        $badges = [
            'rendah' => 'bg-green-100 text-green-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'tinggi' => 'bg-orange-100 text-orange-800',
            'kritis' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->prioritas] ?? 'bg-gray-100 text-gray-800';
    }

    public function getRelawanTersediaAttribute()
    {
        return max(0, $this->relawan_dibutuhkan - $this->relawan_terdaftar);
    }

    public function relawans()
    {
        return $this->hasMany(Relawan::class, 'daerah_butuh_relawan_id');
    }

    public function getPrioritasBadgeClassAttribute()
    {
        return $this->getPrioritasBadgeAttribute();
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeByPrioritas($query, $prioritas)
    {
        return $query->where('prioritas', $prioritas);
    }
}
