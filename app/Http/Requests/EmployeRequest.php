<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employeId = $this->route('employe')?->id;

        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email'      => [
                'nullable',
                'email:rfc,dns',
                'max:255',
                Rule::unique('employes', 'email')->ignore($employeId),
            ],
            'phone' => [
                'required', 'regex:/^\+?[0-9\s\-]{8,20}$/',
                Rule::unique('employes', 'phone')->ignore($employeId),
            ],
        ];
    }
}
