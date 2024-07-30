<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('empuser', 'emppass');

        if (isset($credentials['empuser'])) {
            $empuser = $credentials['empuser'];
        } else {
            // Handle the case where 'empuser' does not exist
            $empuser = null; // or set a default value
            // Optionally, log an error or return an error message
        }

        if (isset($credentials['emppass'])) {
            $emppass = $credentials['emppass'];
        } else {
            // Handle the case where 'emppass' does not exist
            $emppass = null; // or set a default value
            // Optionally, log an error or return an error message
        }

        if (Auth::attempt(['empuser' => $empuser, 'password' => $emppass], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        // Handle failed authentication
        return back()->withErrors([
            'empuser' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
