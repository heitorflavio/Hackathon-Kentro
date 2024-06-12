<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangeStatusDriver extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_available' => 'required|boolean'
        ];
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

     public function messages(): array
     {
         return [
            'is_available.required' => 'Availability is required',
            'is_available.boolean' => 'Availability must be a boolean'
         ];
     }
 
     /**
      * Get custom attributes for validator errors.
      *
      * @return array<string, string>
      */
 
     public function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json($validator->errors(), 422));
     }
}
