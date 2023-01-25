<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
          'domain' => 'required|max:255|unique:domains',
          'company' => 'required|max:255',
//          'name' => 'required|max:255',
//          'email' => 'required|email|max:255|unique:users',
        ];
    }
}
