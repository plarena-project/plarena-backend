<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    /**
     * Mendapatkan label yang bisa dibaca manusia untuk peran.
     * Ini opsional, tapi bisa berguna.
     */
    public function label(): string
    {
        return match ($this) {
            static::ADMIN => 'Administrator',
            static::USER => 'Pengguna Biasa',
        };
    }
}