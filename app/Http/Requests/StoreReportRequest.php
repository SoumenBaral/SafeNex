<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'category_id' => 'required|exists:categories,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'severity' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'occurred_at' => 'nullable|date',
            'media' => 'nullable|array|max:6',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,mp4|max:30720',
        ];
    }
}
