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
        return auth()->check();
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
            'pin' => 'required|digits_between:4,6',
            'email'=>'required',
            'password'=>'required',
            'pesel'=>'required',
            'seria_i_numer_dowodu'=>'required',
            'nr_telefonu'=>'required',
            'miasto'=>'required',
        ];
    }

    public function messages(){
        return [
            'pin.numeric'=>'Pole pin musi być liczbą',
            'pin.digits_between'=>'Pole pin nie może być krótsze niż 4 znaki i dłuższe niż 6 znaków',
            'imie.required' => 'Imię jest wymagane',
            'nazwisko.required'  => 'Nazwisko jest wymagane',
            'pin.required'  => 'Pin jest wymagane',
            'email.required'  => 'Email jest wymagane',
            'password.required'  => 'Hasło jest wymagane',
            'pesel.required'  => 'Pesel jest wymagane',
            'seria_i_numer_dowodu.required'  => 'Seria i numer dowodu jest wymagane',
            'nr_telefonu.required'  => 'Numer telefonu jest wymagany',
            'miasto.required'  => 'Miasto jest wymagane',

        ];
    }
}
