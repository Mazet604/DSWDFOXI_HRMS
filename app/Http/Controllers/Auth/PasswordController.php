<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\EmpAcc;

class PasswordController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();
        $user->emppass = Hash::make($request->input('password'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }
}