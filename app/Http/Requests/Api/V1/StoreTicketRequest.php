<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
        $rules = [
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:A,C,H,X',
        ];

        $this->routeIs('tickets.store') ?? $rules['data.relationships.user.data.id'] = 'required|integer';

        return $rules;
    }

    public function messages()
    {
        return [
            'data.attributes.status.in' => 'The data value is invalid. Please use either A, C, H, or X',
            'data.attributes.status.required' => 'The data value is required',
        ];
    }
}
