<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function index(){

        return view("administrator/adminpanel")
            ->with('administrator', auth()->user()->admin);
    }

}
