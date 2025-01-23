<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Anhskohbo\NoCaptcha\NoCaptcha;

class YourController extends Controller
{
    public function yourFormSubmitMethod(Request $request)
    {
        $request->validate([
            // ...existing validation rules...
            'g-recaptcha-response' => 'required|captcha',
        ]);

        // ...existing code...
    }
}