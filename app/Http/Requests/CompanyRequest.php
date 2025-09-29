<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $rules = [
            'email'   => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = 'required|string|max:255';
        } else {
            $rules['name'] = 'sometimes|required|string|max:255';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('logo')) {
                $image = $this->file('logo');
                [$width, $height] = getimagesize($image->getRealPath());

                if ($width < 100 || $height < 100) {
                    $validator->errors()->add('logo', 'Logo harus berukuran minimal 100x100 piksel.');
                }
            }
        });
    }
}
