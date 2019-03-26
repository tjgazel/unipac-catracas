<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarioRequest extends FormRequest
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
            'identificacao' => 'required|max:100|min:6',
            'data_inicio' => 'required',
            'data_termino' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            toastr()->error('Corrija os erros do formulário');
        }
    }
}
