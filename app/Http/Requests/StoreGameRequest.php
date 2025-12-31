<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
            'num_rows' => ['nullable', 'integer', 'min:3', 'max:10'],
            'selected_categories' => ['nullable', 'array', 'min:2'],
            'selected_categories.*' => ['integer', 'exists:categories,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'num_rows.min' => 'El número de filas debe ser al menos 3.',
            'num_rows.max' => 'El número de filas no puede ser mayor a 10.',
            'selected_categories.min' => 'Debes seleccionar al menos 2 categorías.',
            'selected_categories.*.exists' => 'Una de las categorías seleccionadas no es válida.',
        ];
    }
}
