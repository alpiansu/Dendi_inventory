<?php

namespace App\Http\Controllers\Api\Initial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Initial;
use App\Models\t_const;

class InitialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 401);
            }
            $jwtToken = substr($token, 7);
            $user = JWTAuth::parseToken($jwtToken)->getPayload()->get('id_user');

            $statusInitial = 1;
            $rkeyConst = "SO1";
            $SO1IsTrue = t_const::where('rkey', $rkeyConst)->first();
            if ($SO1IsTrue && $SO1IsTrue->status == 1) {
                $statusInitial = 0;
            }
            $tokenInitial = Str::uuid()->toString();
            Initial::create([
                'id_user' => $user,
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'token' => $tokenInitial,
                'status' => $statusInitial,
            ]);

            return response()->json(['Message' => 'Data initial inserted successfully'], 200);
        } catch (\Exception $exception) {
            // Jika kode kesalahan SQL adalah 23000 (duplikat entri), tangani secara khusus
            if ($exception->getCode() == 23000) {
                return response()->json(['error' => 'Duplicate entry. Your error message here.'], 400);
            } else {
                // Tangani kesalahan lainnya
                return response()->json(['error' => $exception->getMessage()], 500);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err], 500);
        }
    }

    /**
     * Melakukan pengecekan terhadap initial atas user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function check(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 401);
            }
            $jwtToken = substr($token, 7);
            $user = JWTAuth::parseToken($jwtToken)->getPayload()->get('id_user');

            $initial = Initial::where('id_user', $user)
                ->where('tanggal', Carbon::now()->format('Y-m-d'))
                ->where('status', '0')->count();
            return response()->json($initial, 200);
        } catch (\Exception $er) {
            return response()->json($er, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
