<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'desc' => 'required|string',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
