<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
class Administrator extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $primaryKey = 'id_admin';

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

    public function login(array $data,$filled) : bool
    {
        return Auth::guard('administrator')->attempt([
            'email'=>$data['email'],
            'password'=>$data['password']
        ],$filled);
    }

    public function scopeCheckAuth(){
        return Auth::guard('administrator')->check();
    }
    public function scopeGetAdmin() : self
    {
        return Auth::guard('administrator')->user();
    }
}
