<?php

namespace App;

use Auth;

class Administrator extends User
{
    use \Parental\HasParent;

    protected $guard = 'admin';

    protected $table = 'administracja';

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->password;
    }

    protected $fillable = [
        'password', 'pin', 'imie','nazwisko','stanowisko'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_uzytkownika');
    }
}
