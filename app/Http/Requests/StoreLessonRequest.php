<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'cluster_id' => ['required', 'min:5', 'max:9', 'string', 'regex:/^[A-Z0-9-]+$/'],
            'course_id' => ['required', 'string', 'regex:/^[A-Z]{3}\d{5}$/'],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'weekday' => ['required'],
            'duration' => ['required', 'numeric', 'min:1', 'max:4'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'staff_ids' => ['min:1', 'array'],
            'student_ids' => ['nullable', 'array'],
        ];
    }
}
