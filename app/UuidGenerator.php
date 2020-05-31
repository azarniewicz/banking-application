<?php


namespace App;


use Illuminate\Support\Str;

class UuidGenerator
{
    public static function generuj()
    {
        $uuid = Str::uuid()->toString();
        if (Rachunek::whereUuid($uuid)->exists()) {
            return self::generuj();
        }

        return $uuid;
    }
}
