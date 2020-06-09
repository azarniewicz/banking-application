<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KlientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isKlient();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kod_pocztowy'       => 'regex:$\d{2}-\d{3}$',
            'limit_dzienny'      => 'numeric|min:0|not_in:0',
            'ustawienie_budzetu' => 'numeric|min:0|not_in:0'
        ];
    }
}
