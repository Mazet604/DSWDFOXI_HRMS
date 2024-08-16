<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmpAcc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Import Session
use Illuminate\Support\Facades\Log;
use App\Helpers\EmailHelper;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return Inertia::render('Login');
    }

    public function store(Request $request)
{
    $credentials = $request->validate([
        'empuser' => ['required', 'string'],
        'emppass' => ['required', 'string'],
    ]);

    if (Auth::attempt(['empuser' => $credentials['empuser'], 'password' => $credentials['emppass']])) {
        $request->session()->regenerate();
        $user = Auth::user();
        $request->session()->put('user_empmail', $user->empmail);
        $request->session()->put('user_id', (string) $user->empid); // Ensure empID is stored as a string

        Log::info('User logged in, email and ID stored in session: ' . $user->empmail . ', ' . $user->empid);

        // Generate and send OTP
        try {
            $otp = EmailHelper::generateOTP();
            Session::put('otp', $otp);
            EmailHelper::sendOTPEmail($user->empmail, $otp);

            return redirect()->route('otp.form')->with([
                'message' => 'Login successful, OTP sent',
                'otp_required' => true
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send OTP: " . $e->getMessage());
            return back()->withErrors(['otp' => 'Failed to send OTP. Please try again later.']);
        }
    }

    return back()->withErrors([
        'empuser' => 'The provided credentials do not match our records.',
    ]);
}



public function sendOtp(Request $request)
{
    $request->validate([
        'empmail' => ['required', 'email'],
    ]);

    $user = EmpAcc::where('empmail', $request->empmail)->first();

    if ($user) {
        try {
            $otp = EmailHelper::generateOTP();
            Session::put('otp', $otp);
            Session::put('user_empmail', $user->empmail);
            Session::put('user_id', $user->empid);
            EmailHelper::sendOTPEmail($user->empmail, $otp);

            Log::info('OTP sent successfully. Redirecting with otpSent=true');

            return redirect()->route('otp.form', [
                'context' => 'forgot-password',
                'otpSent' => true  // Pass the flag in the redirect
            ])->with('status', 'OTP sent to your email.');
        } catch (\Exception $e) {
            Log::error("Failed to send OTP: " . $e->getMessage());
            return back()->withErrors(['otp' => 'Failed to send OTP. Please try again later.']);
        }
    } else {
        return back()->withErrors(['empmail' => 'No user found with this email.']);
    }
}




public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => ['required', 'string'],
        'context' => ['required', 'string'], // Validate the context
    ]);

    $sessionOtp = Session::get('otp');
    $inputOtp = $request->input('otp');

    if ($sessionOtp === $inputOtp) {
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
            } else {
                // Handle regular login OTP
                Session::put('otp_verified', true);
                Session::forget('otp'); // Clear OTP session to prevent reuse
                return redirect()->route('dashboard');
            }
        } else {
            return back()->withErrors(['user' => 'User not found.']);
        }
    } else {
        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }
}





public function destroy(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();
    session()->flush();

    return redirect('/');
}

}
