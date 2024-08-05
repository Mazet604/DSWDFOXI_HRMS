<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class OTPController extends Controller
{
    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required']);
        $sessionOtp = Session::get('otp');

        if ($request->otp == $sessionOtp) {
            Session::put('otp_verified', true);
            return redirect()->route('dashboard');
        }

        return Inertia::render('Auth/OTP', [
            'error' => 'Invalid OTP.'
        ]);
    }
}

