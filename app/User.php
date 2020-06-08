<?php

namespace App;

use Faker\Provider\pl_PL\Payment;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Events\UstawieniaRedirect;
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'uzytkownicy';

    protected $childColumn = 'typ';

    protected $childTypes = [
        'administrator'  => Administrator::class,
        'klient' => Klient::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imie', 'nazwisko', 'typ', 'pin',
        'email', 'password', 'is_reset_password', 'pesel', 'nr_telefonu', 'ulica_nr', 'kod_pocztowy',
        'miasto', 'seria_i_numer_dowodu','is_zablokowana','is_reset_pin'
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

    public function isKlient()
    {
        return $this->klient()->exists();
    }

    public function admin()
    {
        return $this->hasOne(Administrator::class, 'id_uzytkownika');
    }

    public function isAdmin()
    {
        return $this->admin()->exists();
    }
    public function getUsersFilter($name){
        return $this
            ->whereRaw("concat(imie,' ',nazwisko,' ',email) LIKE '%{$name}%'");
    }
    public function changePassword($password){

        $this->update([
            'is_reset_password'=>0,
            'password'=>Hash::make($password)
        ]);
        return $this;
    }
    public function setResetPassword(){
        $this->update([
            'is_reset_password'=>1
        ]);
        broadcast(new UstawieniaRedirect($this));
        return $this;
    }
    public function edit(array $data) : self{
        $this->update($data);
        return $this;
    }
    public function setLock() : self{
        $this->update([
                'is_zablokowana'=>1
            ]);
        broadcast(new UstawieniaRedirect($this));
        return $this;
    }
    public function setUnlock() : self{
        $this->update([
            'is_zablokowana'=>0,
        ]);
        broadcast(new UstawieniaRedirect($this));
        return $this;
    }
    public function setResetPin() : self{
        $this->update([
            'is_reset_pin'=>1,
        ]);
        broadcast(new UstawieniaRedirect($this));
        return $this;
    }
    public function changePin($pin) : self{
        $this->update([
            'pin'=>$pin,
            'is_reset_pin'=>0
        ]);
        return $this;
    }
    public function store(array $data) : self
    {
        $base = $this->create([
            'imie'=>$data['imie'],
            'nazwisko'=>$data['nazwisko'],
            'pin'=>$data['pin'],
            'email'=>$data['email'],
            'password'=>$data['password'],
            'typ'=>'klient',
            'is_reset_password'=>1,
            'password'=>Hash::make($data['password'])
        ]);


        $klient = new Klient([
            'id_uzytkownika'=>$base->id,
            'pesel'=>$data['pesel'],
            'miasto'=>$data['miasto'],
            'ulica_nr'=>$data['ulica_nr'],
            'kod_pocztowy'=>$data['kod_pocztowy'],
            'nr_telefonu'=>$data['nr_telefonu'],
            'limit_dzienny'=>0,
            'ustawienie_budzetu'=>0]);

        $klient = $base->klient()
            ->save($klient);


        $aggregate = RachunekAggregateRoot::retrieve(UuidGenerator::generuj());
        $aggregate->utworzRachunekKlienta($klient->id, Payment::bankAccountNumber());

        $aggregate->persist();

        return $base;
    }
}
