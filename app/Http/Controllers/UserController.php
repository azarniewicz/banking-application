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
    public function resetPassword(){
        return view('uzytkownik/resetpassword');
    }
    private function validatePassword($password,$repeatPassword){
        return $password === $repeatPassword;
    }
    public function setResetPassword($id){
        $this->user->findOrFail($id)
            ->setResetPassword();
    }
    public function getUsersFilter($name){
        return response()->json(['data'=>$this->user->getUsersFilter($name)->get()]);
    }
    public function changePassword(Request $request){
        if($this->validatePassword($request->password,$request->repeat_password)){
            $user = auth()->user()->changePassword($request->password);
            return redirect()->to("/");
        }
        return redirect()
            ->back()
                ->withErrors(['Podane hasła różnią się']);
    }
    public function store(UserRequest $request){
        $user = $this->user->store($request->all());

        return redirect()
            ->back();
    }

}
