<?php

namespace App\Http\Controllers\Backend\API;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Dinas;
use App\Models\Sakit;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DinasApiController extends Controller
{
    public function simpanDinas(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'alamat' => 'required',
        ]);

        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $existingDinas = Dinas::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->first();

            if ($existingDinas) {
                $existingDinas->update([
                    'keterangan' => $request->input('keterangan'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'alamat' => $request->input('alamat'),
                ]);

                Absensi::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();
                Izin::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();
                Sakit::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();
                Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
                    ->where('tanggal_selesai', '>=', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();

                $responseData = [
                    'message' => 'Data Dinas berhasil diperbarui dan data absensi, izin, sakit, serta cuti dihapus pada tanggal ini.',
                    'data' => [
                        'id' => $existingDinas->id,
                        'user_id' => $existingDinas->user_id,
                        'tanggal' => $existingDinas->tanggal,
                        'keterangan' => $existingDinas->keterangan,
                        'latitude' => $existingDinas->latitude,
                        'alamat' => $existingDinas->alamat,
                    ],
                ];

                return response()->json($responseData, 200);
            } else {
                // Simpan data dinas ke database jika tidak ada entri dinas pada tanggal yang sama
                $dinas = new Dinas;
                $dinas->user_id = $user->id; // Gunakan ID pengguna
                $dinas->tanggal = $request->input('tanggal');
                $dinas->keterangan = $request->input('keterangan');
                $dinas->latitude = $request->input('latitude');
                $dinas->longitude = $request->input('longitude');
                $dinas->alamat = $request->input('alamat');
                $dinas->save();

                Absensi::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();

                Izin::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();

                Sakit::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();

                Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
                    ->where('tanggal_selesai', '>=', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();


                $responseData = [
                    'message' => 'Data Dinas berhasil disimpan dan data absensi, izin, sakit, serta cuti dihapus.',
                    'data' => [
                        'id' => $dinas->id,
                        'user_id' => $dinas->user_id,
                        'tanggal' => $dinas->tanggal,
                        'keterangan' => $dinas->keterangan,
                        'latitude' => $dinas->latitude,
                        'alamat' => $dinas->alamat,
                    ],
                ];

                return response()->json($responseData, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data Dinas. Error: ' . $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $dinasUser = Dinas::where('user_id', $request->input('user_id'))->get();

            if ($dinasUser->isEmpty()) {
                return response()->json(['message' => 'Tidak ada dinas yang ditemukan untuk pengguna ini.'], 404);
            }

            return response()->json([
                'message' => 'Daftar dinas berhasil ditemukan.',
                'success' => true,
                'total' => $dinasUser->count(),
                'data' => $dinasUser,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil daftar dinas. Error: ' . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $request->validate([
                'user_id' => 'required',
                'dinas_id' => 'required',
            ]);

            $deletedDinas = Dinas::where('id', $request->input('dinas_id'))
                ->where('user_id', $request->input('user_id'))
                ->delete();

            if ($deletedDinas) {
                return response()->json(['message' => 'Dinas berhasil dihapus.'], 200);
            } else {
                return response()->json(['message' => 'Dinas tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus Dinas. Error: ' . $e->getMessage()], 500);
        }
    }
}
