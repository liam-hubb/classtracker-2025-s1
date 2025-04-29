<?php

namespace App\Http\Requests\v1;

use App\Classes\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $courseId = $this->route('course')->id;

        return [
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}\d{5}$/', 'unique:courses,national_code,' . $courseId],
            'aqf_level' => ['required', 'min:5', 'max:255', 'string',],
            'title' => ['required', 'min:2', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
            'state_code' => ['required', 'string', 'size:4', 'unique:courses,state_code,' . $courseId],
            'nominal_hours' => ['required', 'min:1', 'max:2000', 'numeric',],
            'type' => ['required', 'min:5', 'max:255', 'string',],
            'qa' => ['sometimes', 'nullable','string', 'size:4', 'unique:courses,qa,' . $courseId],
            'nat_code' => ['sometimes', 'nullable','string', 'regex:/^[A-Z]{3}\d{5}$/', 'unique:courses,nat_code,' . $courseId],
            'nat_title' => ['sometimes', 'nullable','min:2', 'max:255', 'string',],
            'nat_code_title' => ['sometimes','nullable','min:5', 'max:255', 'string',],
            ];
    }
}
