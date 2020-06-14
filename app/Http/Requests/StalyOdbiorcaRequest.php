<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StalyOdbiorcaRequest extends FormRequest
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
            'nr_rachunku' => [
                'required',
                'regex:$[A-Za-z]{2}[0-9]{26}\z$',
                'exists:rachunki,nr_rachunku',
                'not_in:' . auth()->user()->getRachunekKlienta()->nr_rachunku
            ],
            'nazwa' => 'required',
            'nazwa_adres' => 'required'
        ];
    }
}
