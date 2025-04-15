<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'status' => 'required|in:open,closed'
        ];
    }
}