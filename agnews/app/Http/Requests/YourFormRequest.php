<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Anhskohbo\NoCaptcha\Rules\Captcha;

class YourFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // ...existing rules...
        ];
    }
}