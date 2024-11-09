<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAdminRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';  
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'cpf' => 'required|string|size:11|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ];
    }
}
