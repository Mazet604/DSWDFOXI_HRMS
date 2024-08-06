<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmpAcc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Import Session
use Illuminate\Support\Facades\Log;
use App\Helpers\EmailHelper;
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
        $user = auth()->user();
        $request->session()->put('user_email', $user->empmail);
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
            'email' => ['required', 'email'],
        ]);
    
        $userEmail = $request->input('email');
    }
    
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string'],
        ]);
    
        $sessionOtp = Session::get('otp');
        $inputOtp = $request->input('otp');
    
        if ($sessionOtp === $inputOtp) {
            $userId = Session::get('user_id');
            $user = EmpAcc::find($userId);
    
            if ($user) {
                // OTP verified, display user data
                return view('user.dashboard', ['user' => $user]);
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
        session::flush();

        return redirect('/');
    }
}
