<?php

namespace App\Http\Requests;

use App\Transakcja;
use Illuminate\Foundation\Http\FormRequest;

class TransakcjaRequest extends FormRequest
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
        $rules = [
            'numer_rachunku' => [
                'required',
                'regex:$[A-Za-z]{2}[0-9]{26}\z$',
                'exists:rachunki,nr_rachunku',
                'not_in:' . auth()->user()->getRachunekKlienta()->nr_rachunku
            ],
            'kwota'          => 'required|numeric',
            'tytul'          => 'required',
            'odbiorca'       => 'required',
            'typ'            => [
                'in:' . Transakcja::ekspres . ',' . Transakcja::standard . ',' . Transakcja::planowana,
                'required'
            ]
        ];

        if ($this->request->has('data_wykonania')) {
            $rules['data_wykonania'] = 'required|date|after:today';
        }

        return $rules;
    }
}
