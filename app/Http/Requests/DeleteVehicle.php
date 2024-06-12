<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteVehicle extends FormRequest
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
            'license_plate' => 'required|string|exists:vehicles,license_plate'
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
                'license_plate.required' => 'License plate is required',
                'license_plate.string' => 'License plate must be a string',
                'license_plate.exists' => 'License plate does not exist'
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
