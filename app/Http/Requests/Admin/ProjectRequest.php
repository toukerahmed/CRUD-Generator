<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'descrioption' => 'required',
            'status' => 'required|in:active,inactive'
        ];
    }
}