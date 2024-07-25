<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\MasterUser;

class ApiLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $user = MasterUser::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->passw)) {
            if (!$user) {
                return response()->json('Username tidak ditemukan!', 404);
            } else {
                return response()->json('Password salah!', 401);
            }
        }

        $tokenExp = Carbon::now()->addHours(10)->timestamp;

        $token = JWTAuth::claims(['id_user' => $user->id_user, 'exp' => $tokenExp])
            ->fromUser($user);

        return response()->json($token, 200);;
    }
}
