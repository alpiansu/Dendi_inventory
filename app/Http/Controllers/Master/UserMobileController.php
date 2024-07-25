<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Models\MasterUser;

class UserMobileController extends Controller
{
    public function index()
    {
        $users = MasterUser::all();
        return view('user_mobile.index', compact('users'));
    }

    public function create()
    {
        return view('user_mobile.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'nama_user' => 'required',
                'password' => 'required|confirmed',
            ]);

            MasterUser::create([
                'username' => $request->username,
                'nama_user' => $request->nama_user,
                'passw' => bcrypt($request->password),
            ]);

            return redirect()->route('user_mobile.create')->with('success', 'User berhasil didaftarkan.');
        } catch (\Exception $e) {
            $getmsg = $e->getmessage();
            return redirect()->route('user_mobile.create')->with('error', 'Terjadi kesalahan. : ' . $getmsg . ' Silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        try {
            $user = MasterUser::where('id_user', $id)->firstOrFail();
            $user->delete();
            return redirect()->route('user_mobile.index')->with('success', 'User berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('user_mobile.index')->with('error', 'User tidak ditemukan.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->route('user_mobile.index')->with('error', 'Terjadi kesalahan. : ' . $errorMessage . ' Silakan coba lagi.');
        }
    }

    public function resetPassword($id)
    {
        try {
            $user = MasterUser::where('id_user', $id)->firstOrFail();
            $user->passw = bcrypt('password123');
            $user->save();
            return redirect()->route('user_mobile.index')->with('success', 'Password user berhasil direset.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('user_mobile.index')->with('error', 'User tidak ditemukan.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->route('user_mobile.index')->with('error', 'Terjadi kesalahan. : ' . $errorMessage . ' Silakan coba lagi.');
        }
    }
}
