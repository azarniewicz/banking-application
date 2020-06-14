<?php


namespace App;


use Illuminate\Support\Str;

class UuidGenerator
{
    /**
     * Zwraca uuid dla nowego rachunku, upewniając się ze takie uuid nie jest już wykorzystywane
     *
     * @return string
     */
    public static function generuj()
    {
        $uuid = Str::uuid()->toString();
        if (Rachunek::whereId($uuid)->exists()) {
            return self::generuj();
        }

        return $uuid;
    }
}
