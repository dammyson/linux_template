<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class CreateSmsRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required|string|size:13',
        ];
    }
}