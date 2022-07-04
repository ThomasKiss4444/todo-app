<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class ItemListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['per_page' => "array", 'page' => "string[]", 'completed' => "string", 'name' => "string"])]
    public function rules(): array
    {
        return [
            'per_page' => [ 'integer', Rule::in([10, 30, 50, 100]) ],
            'page' => [ 'integer' ],
            'completed' => 'boolean',
            'name' => 'string'
        ];
    }
}
