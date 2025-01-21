<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class FormController extends Controller
{
    // ...existing code...

    public function submit(Request $request)
    {
        $request->validate([
            // ...existing validation rules...
            'g-recaptcha-response' => 'required|captcha',
        ]);

        // Verify reCAPTCHA
        $recaptcha = new \ReCaptcha\ReCaptcha('6LeEx74qAAAAAHHsm-VmV_dN-kDIudQbMAmxl0YU');
        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$resp->isSuccess()) {
            return back()->withErrors(['captcha' => 'ReCAPTCHA verification failed.']);
        }

        // ...existing code...
    }

    // ...existing code...
}
