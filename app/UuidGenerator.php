<?php


namespace App;


use Illuminate\Support\Str;

class UuidGenerator
{
    public static function generuj()
    {
        $uuid = Str::uuid()->toString();
        if (Rachunek::where('uuid', $uuid)->count()) {
            return self::generuj();
        }

        return $uuid;
    }
}
