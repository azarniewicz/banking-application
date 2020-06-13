<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KredytRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kwota_kredytu'=>'required|numeric|min:1'
        ];
    }
    public function messages(){
        return [
            'kwota_kredytu.required'=>'Kwota kredytu nie może być pusta',
            'kwota_kredytu.min'=>'Kwota kredytu nie może być mniejsza od 1',
            'kwota_kredytu.numeric'=>'Nie poprawny format kwoty kredytu',
        ];
    }
}
