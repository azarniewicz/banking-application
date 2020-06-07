<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use App\RachunekAggregateRoot;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth:administrator')->except('update');
    }

    public function store(UserRequest $request)
    {
        $user = $this->user->store($request->all());

        return redirect()
            ->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'pin'   => 'numeric|nullable',
            'email' => 'unique:uzytkownicy,email|nullable',
        ]);

        auth()->user()->update($request->all());

        return redirect()->back()->with('success', 'Dane logowania pomyślnie zaktualizowane.');
    }
}
