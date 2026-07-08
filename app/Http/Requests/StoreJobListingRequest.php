<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'employer';
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:100',
            'description' => 'required|min:10',
            'location' => 'required|string',
            'salary_range' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'required|in:Full-time,Part-time,Contract',
            'selectedTagIds' => 'nullable|array',
            'selectedTagIds.*' => 'exists:tags,id',
            'expires_at' => 'nullable|date|after:today',
        ];
    }
}
