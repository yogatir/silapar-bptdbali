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

    /**
     * Get pelabuhan configurations with their dermaga structure
     */
    public static function getPelabuhanConfig(): array
    {
        return [
            'gilimanuk' => [
                'nama' => 'Gilimanuk',
                'dermaga' => [
                    ['nama' => 'Dermaga MB I', 'kapal' => []],
                    ['nama' => 'Dermaga MB II', 'kapal' => []],
                    ['nama' => 'Dermaga MB III', 'kapal' => []],
                    ['nama' => 'Dermaga MB IV', 'kapal' => []],
                    ['nama' => 'Dermaga LCM', 'kapal' => []],
                ],
                'show_form' => true,
            ],
            'padangbai' => [
                'nama' => 'Padangbai',
                'dermaga' => [
                    ['nama' => 'Dermaga 1', 'kapal' => []],
                    ['nama' => 'Dermaga 2', 'kapal' => []],
                ],
                'show_form' => true,
            ],
            'sampalan' => [
                'nama' => 'Sampalan',
                'dermaga' => [
                    ['nama' => 'Dermaga 1', 'kapal' => []],
                    ['nama' => 'Dermaga 2', 'kapal' => []],
                    ['nama' => 'Dermaga 3', 'kapal' => []],
                    ['nama' => 'Dermaga 4', 'kapal' => []],
                    ['nama' => 'Dermaga Exiting', 'kapal' => []],
                ],
                'show_form' => true,
            ],
            'danau_bedugul' => [
                'nama' => 'Danau Bedugul',
                'dermaga' => [],
                'show_form' => false,
            ],
            'danau_batur_kedisan' => [
                'nama' => 'Danau Batur Kedisan',
                'dermaga' => [],
                'show_form' => false,
            ],
        ];
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
