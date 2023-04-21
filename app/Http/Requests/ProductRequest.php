<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required' , 'string' ,'max:255'],
            'price' => ['required','integer'],
            'description' => ['required','string'],
            'quantity' => ['required','integer'],
            'image.*' => ['required','image','mimes:jpg,jpeg,png,giv,svg'],
            'category_id' => ['integer', 'required', 'exists:categories,id'],
        ];
    }

    public function message()
    {
        return[
            'name.required' => 'name is required'
        ];
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Unprocessable Content',
                'errors' => $errors
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
