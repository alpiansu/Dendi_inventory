<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('account/change-password');
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|confirmed|min:8',
            ]);

            $user = auth()->user();

            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages(['current_password' => 'The current password is incorrect.']);
            }

            $user->update(['password' => Hash::make($request->password)]);

            return redirect()->back()->with('success', 'Password has been changed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
