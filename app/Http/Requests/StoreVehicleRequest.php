<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreVehicleRequest extends FormRequest
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
            "model" => "required|string",
            "make" => "required|string",
            "license_plate" => "required|string",
            "color" => "required|string",
            "year" => "required|integer",
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
                'model.required' => 'Model is required',
                'make.required' => 'Make is required',
                'license_plate.required' => 'License plate is required',
                'color.required' => 'Color is required',
                'year.required' => 'Year is required',
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
