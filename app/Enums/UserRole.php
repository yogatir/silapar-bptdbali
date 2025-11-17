<?php

namespace App\Enums;

final class UserRole
{
    public const KABALAI = 'KABALAI';
    public const SEKSI = 'SEKSI';
    public const SATPEL = 'SATPEL';

    /**
     * @return array<int, string>
     */
    public static function all(): array
    {
        return [
            self::KABALAI,
            self::SEKSI,
            self::SATPEL,
        ];
    }
}


