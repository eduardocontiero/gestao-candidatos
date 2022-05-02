<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Arr;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ];

        if($this->id){
            $rules += ['username' => 'required'];
            $rules += ['password' => 'required|confirmed'];
        }

        return $rules;
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['success' => false, 'errors'=>Arr::flatten($validator->messages()->get('*'))], 422));

    }
}