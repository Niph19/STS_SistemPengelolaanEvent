<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengelolaEventStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date' => ['required', 'date', 'after:now'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,ongoing,completed,canceled'],
        ];
    }
}
