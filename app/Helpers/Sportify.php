<?php

namespace App\Helpers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\PemilikLapangan;

class Sportify
{
    public static function check(): bool
    {
        return session()->has('sportify_user_id');
    }

    public static function role(): ?string
    {
        return session('sportify_user_role');
    }

    public static function user()
    {
        $role = self::role();
        $id = session('sportify_user_id');

        if (!$id || !$role) {
            return null;
        }

        return match ($role) {
            'admin' => Admin::find($id),
            'pemilik' => PemilikLapangan::find($id),
            'customer' => Customer::find($id),
            default => null,
        };
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'admin';
    }

    public static function isPemilik(): bool
    {
        return self::role() === 'pemilik';
    }

    public static function isCustomer(): bool
    {
        return self::role() === 'customer';
    }

    public static function rupiah($amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
