<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use App\RachunekAggregateRoot;

class UserController extends  Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function store(UserRequest $request){
        $user = $this->user->store($request->all());

        return redirect()
            ->back();
    }

}
