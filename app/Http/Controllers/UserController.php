<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
    private function validatePin($pin){
        $validator = Validator::make(['pin'=>$pin], [
            'pin' => 'required|digits_between:4,6',
        ],[
            'pin.numeric'=>'Pole pin musi być liczbą',
            'pin.digits_between'=>'Pole pin nie może być krótsze niż 4 znaki i dłuższe niż 6 znaków'
        ]);

        return $validator;
    }
    public function setResetPassword($id){
        $this->user->findOrFail($id)
            ->setResetPassword();
    }
    public function getUsersFilter($name){
        return response()->json(['data'=>$this->user->getUsersFilter($name)->get()]);
    }
    public function changePin(Request $request){
        $validator = $this->validatePin($request->pin);
        if($validator->fails()){
            return redirect()
                ->back()
                    ->withErrors($validator);
        }
        auth()->user()->changePin($request->pin);
        return redirect()->to("/");
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
    public function resetPin(){
        return view('/uzytkownik/resetpin');
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
