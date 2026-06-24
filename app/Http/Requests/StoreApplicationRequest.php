<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'resume.required' => __('messages.validation.resume_required'),
            'resume.mimes'    => __('messages.validation.resume_mimes'),
            'resume.max'      => __('messages.validation.resume_max'),
        ];
    }
}
