<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    use HasFactory;

    protected $table = 'pelabuhan_records';

    protected $fillable = [
        'tanggal',
        'waktu',
        'pelabuhan',
        'kapal_operasi',
        'trip',
        'penumpang',
        'roda_2',
        'roda_4_penumpang',
        'roda_4_barang',
        'dermaga',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'kapal_operasi' => 'integer',
            'trip' => 'integer',
            'penumpang' => 'integer',
            'roda_2' => 'integer',
            'roda_4_penumpang' => 'integer',
            'roda_4_barang' => 'integer',
            'dermaga' => 'array',
        ];
    }

    public static function getPelabuhanConfig(): array
    {
        return config('pelabuhan.options', []);
    }

    /**
     * Get dermaga configuration for a specific pelabuhan
     */
    public static function getDermagaConfig(string $pelabuhan): ?array
    {
        $config = self::getPelabuhanConfig();

        return $config[$pelabuhan] ?? null;
    }

    /**
     * Get pelabuhan name from key
     */
    public function getPelabuhanNameAttribute(): string
    {
        $config = self::getPelabuhanConfig();

        return $config[$this->pelabuhan]['nama'] ?? ucfirst(str_replace('_', ' ', $this->pelabuhan));
    }
}
