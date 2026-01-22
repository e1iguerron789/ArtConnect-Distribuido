<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
        'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñ ]+$/'],
        
        'username' => [
            'required',
            'string',
            'max:50',
            'regex:/^[A-Za-zÑñ0-9_]+$/',
            'unique:users,username,' . $this->user()->id,
        ],

        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email,' . $this->user()->id,
        ],

        'edad' => ['required', 'integer', 'min:5', 'max:120'],
    ];
    }
}
