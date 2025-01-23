<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        // Store or update user consent status
        CookieConsent::updateOrCreate(
            ['user_id' => $user->id],
            ['has_consented' => true]
        );

        return response()->json(['status' => 'success']);
    }
}

