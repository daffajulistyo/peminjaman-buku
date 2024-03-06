<?php

namespace App\Http\Controllers\Backend\API;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Dinas;
use App\Models\Sakit;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IzinApiController extends Controller
{
    public function simpanIzin(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required',
        ]);

        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $existingIzin = Izin::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->first();

            if ($existingIzin) {
                $existingIzin->update([
                    'keterangan' => $request->input('keterangan'),
                ]);
                Absensi::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();
                Dinas::where('tanggal', $request->input('tanggal'))
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
                    'message' => 'Data Izin berhasil diperbarui dan data absensi, dinas, sakit, serta cuti dihapus pada tanggal ini.',
                    'data' => [
                        'id' => $existingIzin->id,
                        'user_id' => $existingIzin->user_id,
                        'tanggal' => $existingIzin->tanggal,
                        'keterangan' => $existingIzin->keterangan,
                    ],
                ];

                return response()->json($responseData, 200);
            } else {
                $izin = new Izin;
                $izin->user_id = $user->id;
                $izin->tanggal = $request->input('tanggal');
                $izin->keterangan = $request->input('keterangan');
                $izin->save();
            }

            Absensi::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->delete();

            Sakit::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->delete();

            Dinas::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->delete();

            Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
                ->where('tanggal_selesai', '>=', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->delete();

            $responseData = [
                'message' => 'Data Izin berhasil disimpan dan data dinas, absensi, sakit, serta cuti dihapus.',
                'data' => [
                    'id' => $izin->id,
                    'user_id' => $izin->user_id,
                    'tanggal' => $izin->tanggal,
                    'keterangan' => $izin->keterangan,
                ],
            ];

            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons error
            return response()->json(['error' => 'Gagal menyimpan data Izin. Error: ' . $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $izinUser = Izin::where('user_id', $request->input('user_id'))->get();

            if ($izinUser->isEmpty()) {
                return response()->json(['message' => 'Tidak ada izin yang ditemukan untuk pengguna ini.'], 404);
            }

            return response()->json([
                'message' => 'Daftar izin berhasil ditemukan.',
                'success' => true,
                'total' => $izinUser->count(),
                'data' => $izinUser,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil daftar izin. Error: ' . $e->getMessage()], 500);
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
                'izin_id' => 'required',
            ]);

            $deletedIzin = Izin::where('id', $request->input('izin_id'))
                ->where('user_id', $request->input('user_id'))
                ->delete();

            if ($deletedIzin) {
                return response()->json(['message' => 'Izin berhasil dihapus.'], 200);
            } else {
                return response()->json(['message' => 'Izin tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus Izin. Error: ' . $e->getMessage()], 500);
        }
    }
}
