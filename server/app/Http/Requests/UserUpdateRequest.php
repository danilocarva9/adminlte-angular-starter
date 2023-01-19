<?php
namespace App\Http\Requests;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string'
        ];
    }

    public function messages()
    {
       return [ 
        'email.required' => 'adadada'
       ];
    }

    public function prepareForValidation()
    {
       
    }
  
}
