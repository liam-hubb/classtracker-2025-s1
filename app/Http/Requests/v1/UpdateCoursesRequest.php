<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursesRequest extends FormRequest
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
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}\d{5}$/'],
            'aqf_level' => ['required', 'min:5', 'max:255', 'string',],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
            'state_code' => ['required', 'string', 'size:4'],
            'nominal_hours' => ['required', 'min:1', 'max:2000', 'numeric',],
            'type' => ['required', 'min:5', 'max:255', 'string',],
            'qa' => ['sometimes', 'nullable','string', 'size:4'],
            'nat_code' => ['sometimes', 'nullable','string', 'regex:/^[A-Z]{3}\d{5}$/'],
            'nat_title' => ['sometimes', 'nullable','min:5', 'max:255', 'string',],
            'nat_code_title' => ['required','min:5', 'max:255', 'string',],
            ];
    }
}
