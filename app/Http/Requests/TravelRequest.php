<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'is_public' => ['boolean'],
            'name' => $this->isMethod('PUT') ? ['required', 'unique:travels,name,' . $this->travel?->id] : ['required', 'unique:travels'],
            'description' => ['required'],
            'number_of_days' => ['required', 'integer'],
        ];
    }
}
