<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\EmpAcc;
use Inertia\Inertia;

class OTPController extends Controller
{
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'context' => 'required|string',  // Ensure context is provided
        ]);

        $sessionOtp = Session::get('otp');

        if ($request->otp == $sessionOtp) {
            $userId = Session::get('user_id');
            $user = EmpAcc::find($userId);

            if ($user) {
                if ($request->input('context') === 'forgot-password') {
                    // OTP verified, reset password to "12345"
                    $user->password = '12345';
                    $user->save();

                    // Clear OTP session and logout the user
                    Session::forget('otp');
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')->with('status', 'Password reset to "12345". Please log in with your new credentials.');
                } elseif ($request->input('context') === 'login') {
                    // Handle regular login OTP
                    Session::put('otp_verified', true);
                    Session::forget('otp'); // Clear OTP session to prevent reuse
                    return redirect()->route('dashboard');
                } else {
                    return back()->withErrors(['context' => 'Invalid context provided.']);
                }
            } else {
                return back()->withErrors(['user' => 'User not found.']);
            }
        }

        return Inertia::render('Auth/OTP', [
            'error' => 'Invalid OTP.'
        ]);
    }
}
