<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    public function create()
    {
        return view('change-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'password'],
            'password' => ['required', 'confirmed'],
        ]);
        $user = Auth::user();

        $user->forceFill([
            'password' => Hash::make($request->input('password'))
        ])->save();

        return redirect()->route('profile')
            ->with('success', 'Password changed');
    }
}
