<?php

namespace App\Http\Controllers\Backend\API;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Dinas;
use App\Models\Sakit;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SakitApiController extends Controller
{
    public function simpanSakit(Request $request)
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

            $existingSakit = Sakit::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->first();

            if ($existingSakit) {
                $existingSakit->update([
                    'keterangan' => $request->input('keterangan'),
                ]);
                Absensi::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();
                Dinas::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();
                Izin::where('tanggal', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();
                Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
                    ->where('tanggal_selesai', '>=', $request->input('tanggal'))
                    ->where('user_id', $user->id)
                    ->delete();

                $responseData = [
                    'message' => 'Data Izin berhasil diperbarui dan data absensi, dinas, izin, serta cuti dihapus pada tanggal ini.',
                    'data' => [
                        'id' => $existingSakit->id,
                        'user_id' => $existingSakit->user_id,
                        'tanggal' => $existingSakit->tanggal,
                        'keterangan' => $existingSakit->keterangan,
                    ],
                ];

                return response()->json($responseData, 200);
            } else {
                $sakit = new Sakit;
                $sakit->user_id = $user->id;
                $sakit->tanggal = $request->input('tanggal');
                $sakit->keterangan = $request->input('keterangan');
                $sakit->save();
            }

            Absensi::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $user->id)
                ->delete();

            Izin::where('tanggal', $request->input('tanggal'))
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
                'message' => 'Data Sakit berhasil disimpan dan data dinas, absensi, izin, serta cuti dihapus.',
                'data' => [
                    'id' => $sakit->id,
                    'user_id' => $sakit->user_id,
                    'tanggal' => $sakit->tanggal,
                    'keterangan' => $sakit->keterangan,
                ],
            ];

            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons error
            return response()->json(['error' => 'Gagal menyimpan data Sakit. Error: ' . $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $sakitUser = Sakit::where('user_id', $request->input('user_id'))->get();

            if ($sakitUser->isEmpty()) {
                return response()->json(['message' => 'Tidak ada sakit yang ditemukan untuk pengguna ini.'], 404);
            }

            return response()->json([
                'message' => 'Daftar sakit berhasil ditemukan.',
                'success' => true,
                'total' => $sakitUser->count(),
                'data' => $sakitUser,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil daftar sakit. Error: ' . $e->getMessage()], 500);
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
                'sakit_id' => 'required',
            ]);

            $deletedSakit = Sakit::where('id', $request->input('sakit_id'))
                ->where('user_id', $request->input('user_id'))
                ->delete();

            if ($deletedSakit) {
                return response()->json(['message' => 'Sakit berhasil dihapus.'], 200);
            } else {
                return response()->json(['message' => 'Sakit tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus Sakit. Error: ' . $e->getMessage()], 500);
        }
    }
}
