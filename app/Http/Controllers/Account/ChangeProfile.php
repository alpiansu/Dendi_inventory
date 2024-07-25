<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangeProfile extends Controller
{
    public function showProfile()
    {
        return view('account/change-profile');
    }

    public function changeProfile(Request $request)
    {
        try {
            $request->validate([
                'profile_name' => 'required',
                'username' => 'required',
            ]);

            $user = auth()->user();
            $user->update(['name' => $request->profile_name]);

            return redirect()->back()->with('success', 'Profile has been updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
