<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'question_text' => ['required', 'string', 'max:1000'],
            'correct_answer' => ['required', 'string', 'max:500'],
            'points' => ['required', 'integer', 'in:100,200,300,400,500'],
            'time_limit' => ['required', 'integer', 'min:10', 'max:300'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Debe seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'question_text.required' => 'El texto de la pregunta es obligatorio.',
            'question_text.max' => 'La pregunta no puede exceder 1000 caracteres.',
            'correct_answer.required' => 'La respuesta correcta es obligatoria.',
            'correct_answer.max' => 'La respuesta no puede exceder 500 caracteres.',
            'points.required' => 'Debe asignar un puntaje.',
            'points.in' => 'El puntaje debe ser 100, 200, 300, 400 o 500.',
            'time_limit.required' => 'Debe especificar un tiempo límite.',
            'time_limit.min' => 'El tiempo mínimo es 10 segundos.',
            'time_limit.max' => 'El tiempo máximo es 300 segundos (5 minutos).',
        ];
    }
}
