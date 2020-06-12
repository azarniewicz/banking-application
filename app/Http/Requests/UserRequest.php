<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'imie'=>'required',
            'nazwisko'=>'required',
            'pin' => 'sometimes|required|digits_between:4,6',
            'email'=>'sometimes|required|email|unique:uzytkownicy,email,'.$this->id,
            'password'=>'sometimes|required|min:6|max:12',
            'pesel'=>'required|digits_between:11,11',
            'nr_dowodu'=>'required',
            'nr_telefonu'=>'required',
            'miasto'=>'required',
            'tymczasowe_haslo'=>'nullable|min:6|max:12'
        ];
    }

    public function messages(){
        return [
            'pesel.digits_between'=>'Pesel musi mieć 11 znaków',
            'email.email'=>'Nieprawidłowy format danych - email',
            'email.unique'=>'Występuje już taki email w bazie',
            'password.min'=>'Hasło nie może być krótsze niż 6',
            'password.max'=>'Hasło nie może być dłuższe niż 12 znaków',
            'tymczasowe_haslo.min'=>'Hasło nie może być krótsze niż 6',
            'tymczasowe_haslo.max'=>'Hasło nie może być dłuższe niż 12 znaków',
            'pin.numeric'=>'Pole pin musi być liczbą',
            'pin.digits_between'=>'Pole pin nie może być krótsze niż 4 znaki i dłuższe niż 6 znaków',
            'imie.required' => 'Imię jest wymagane',
            'nazwisko.required'  => 'Nazwisko jest wymagane',
            'pin.required'  => 'Pin jest wymagane',
            'email.required'  => 'Email jest wymagane',
            'password.required'  => 'Hasło jest wymagane',
            'pesel.required'  => 'Pesel jest wymagane',
            'nr_dowodu.required'  => 'Seria i numer dowodu jest wymagane',
            'nr_telefonu.required'  => 'Numer telefonu jest wymagany',
            'miasto.required'  => 'Miasto jest wymagane',

        ];
    }
}
