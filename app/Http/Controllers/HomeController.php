<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Parental\Tests\Models\Admin;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return redirect('adminpanel');
        }

        return redirect('start');
    }

    public function test(){
        User::create([
            'email'=>'milosz981998@gmail.com',
            'password'=>Hash::make('123456'),
            'name'=>'Miłosz Męczyński'
        ]);
    }
}
