<?php

namespace App;

use Faker\Provider\pl_PL\Payment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'uzytkownicy';

    protected $childColumn = 'typ';

    protected $childTypes = [
//        'admin' => App\Admin::class,
        'klient' => Klient::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imie','nazwisko','typ','pin',
        'email', 'password','is_reset_password','pesel','numer_telefonu','ulica_i_numer_domu','kod_pocztowy','miasto','seria_i_numer_dowodu'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPelneImieAttribute()
    {
        return $this->imie . ' ' . $this->nazwisko;
    }
    public function klient()
    {
        return $this->hasOne(Klient::class, 'id_uzytkownika');
    }
    public function store(array $data)
    {

        $data['is_reset_password'] = 1;
        $data['password'] = Hash::make($data['password']);
        $base = $this->create($data);

        $aggregate = RachunekAggregateRoot::retrieve(UuidGenerator::generuj());
        $aggregate->utworzRachunekKlienta($base->id, Payment::bankAccountNumber());

        $aggregate->persist();

        return $base;
    }
}
