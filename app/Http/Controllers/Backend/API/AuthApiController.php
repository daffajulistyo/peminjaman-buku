<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Koordinat;
use App\Models\User;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('nip', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid nip or password'], 401);
        }

        $user = $request->user();
        if (empty($user->uuid)) {
            $user->uuid = Str::uuid();
            $user->save();
        }

        if ($user->is_active == 1) {
            return response()->json(['message' => 'User is already logged in on another device'], 401);
        }

        // Set is_active to 1 to mark the user as active
        $user->is_active = 1;
        $user->save();

        // Further code for generating tokens and returning response
        $opdId = $user->opd_id;

        $opdData = [];
        if ($opdId) {
            $opd = Opd::find($opdId);
            if ($opd) {
                $opdData = [
                    'opd' => $opd->id,
                    'opd_name' => $opd->name,
                ];
            }
        }

        $laporanAkses = $user->laporan_akses;

        $response = [
            'token' => $user->createToken('MyApp')->accessToken,
            'id' => $user->id,
            'name' => $user->name,
            'uuid' => $user->uuid,
            'akses' => $laporanAkses,
        ];

        // Merge OPD data into the response
        $response = array_merge($response, $opdData);

        return response()->json($response, 200);
    }

    public function loginEselonDua(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('nip', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid nip or password'], 401);
        }

        $user = $request->user();
        if (empty($user->uuid)) {
            $user->uuid = Str::uuid();
            $user->save();
        }

        $userEselon = $user->eselon;

    if (!$userEselon || $userEselon->name !== 'Eselon II') {
        return response()->json(['message' => 'Unauthorized access'], 403);
    }

        if ($user->is_active == 1) {
            return response()->json(['message' => 'Pengguna Sudah Login di Perangkat Lain'], 401);
        }

        // Set is_active to 1 to mark the user as active
        $user->is_active = 1;
        $user->save();

        // Further code for generating tokens and returning response
        $opdId = $user->opd_id;

        $opdData = [];
        if ($opdId) {
            $opd = Opd::find($opdId);
            if ($opd) {
                $opdData = [
                    'opd' => $opd->id,
                    'opd_name' => $opd->name,
                ];
            }
        }

        $laporanAkses = $user->laporan_akses;

        $response = [
            'token' => $user->createToken('MyApp')->accessToken,
            'id' => $user->id,
            'name' => $user->name,
            'uuid' => $user->uuid,
            'akses' => $laporanAkses,
        ];

        // Merge OPD data into the response
        $response = array_merge($response, $opdData);

        return response()->json($response, 200);
    }


    public function logout(Request $request)
    {
        $user = $request->user();

        // Revoke the access token
        $user->token()->revoke();

        // Set is_active to 0 to mark the user as inactive
        $user->is_active = 0;
        $user->save();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function getUserMultiDetails(Request $request)
    {
        // auth
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $userData = [
                'name' => $user->name,
                'piket' => $user->is_piket,
                'opd' => [
                    'name' => $user->opd->name,
                    'koordinat' => [],
                ],
            ];

            foreach ($user->opd->koordinats as $koordinat) {
                $userData['opd']['koordinat'][] = [
                    'latitude' => $koordinat->latitude,
                    'longitude' => $koordinat->longitude,
                    'radius' => $koordinat->radius,
                ];
            }

            return response()->json(['data' => $userData], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function getUserDetails(Request $request)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $userData = [
                'name' => $user->name,
                'opd' => $user->opd->name,
                'latitude' => $user->opd->koordinats[0]->latitude,
                'longitude' => $user->opd->koordinats[0]->longitude,
            ];

            return response()->json(['data' => $userData], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function getUserCoordinates(Request $request)
    {
        $user = Auth::user();

        if ($user->opd && $user->opd->koordinats->isNotEmpty()) {
            $latitude = $user->opd->koordinats[0]->latitude;
            $longitude = $user->opd->koordinats[0]->longitude;

            return response()->json([
                'name' => $user->name,
                'opd' => $user->opd->name,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        } else {
            return response()->json(['message' => 'Koordinat tidak ditemukan'], 404);
        }
    }
}
