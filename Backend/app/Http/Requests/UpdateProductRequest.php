<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer esta solicitação.
     */
    public function authorize(): bool
    {
        // Retorne true para autorizar a requisição
        return true;
    }

    /**
     * Regras de validação para atualização do produto.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required',
        ];
    }
}
