<?php

namespace App\Http\Controllers\Backend\API;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Dinas;
use App\Models\Sakit;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CutiApiController extends Controller
{
    public function simpanCuti(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required',
        ]);

        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $existingCuti = Cuti::where('tanggal_mulai', '<=', $request->input('tanggal_mulai'))
                ->where('tanggal_selesai', '>=', $request->input('tanggal_selesai'))
                ->where('user_id', $user->id)
                ->first();

            if ($existingCuti) {
                $existingCuti->update([
                    'tanggal_mulai' => $request->input('tanggal_mulai'),
                    'tanggal_selesai' => $request->input('tanggal_selesai'),
                    'keterangan' => $request->input('keterangan'),
                ]);
            } else {
                $existingCuti = new Cuti;
                $existingCuti->user_id = $user->id;
                $existingCuti->tanggal_mulai = $request->input('tanggal_mulai');
                $existingCuti->tanggal_selesai = $request->input('tanggal_selesai');
                $existingCuti->keterangan = $request->input('keterangan');
                $existingCuti->save();
            }

            Absensi::whereBetween('tanggal', [$existingCuti->tanggal_mulai, $existingCuti->tanggal_selesai])
                ->where('user_id', $user->id)
                ->delete();
            Izin::whereBetween('tanggal', [$existingCuti->tanggal_mulai, $existingCuti->tanggal_selesai])
                ->where('user_id', $user->id)
                ->delete();
            Sakit::whereBetween('tanggal', [$existingCuti->tanggal_mulai, $existingCuti->tanggal_selesai])
                ->where('user_id', $user->id)
                ->delete();
            Dinas::whereBetween('tanggal', [$existingCuti->tanggal_mulai, $existingCuti->tanggal_selesai])
                ->where('user_id', $user->id)
                ->delete();

            $responseData = [
                'message' => 'Data Cuti berhasil disimpan/diperbarui dan data absensi, izin, sakit, serta dinas dihapus.',
                'data' => [
                    'id' => $existingCuti->id,
                    'user_id' => $existingCuti->user_id,
                    'tanggal_mulai' => $existingCuti->tanggal_mulai,
                    'tanggal_selesai' => $existingCuti->tanggal_selesai,
                    'keterangan' => $existingCuti->keterangan,
                ],
            ];

            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data Cuti. Error: ' . $e->getMessage()], 500);
        }
    }


    public function index(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $cutiUser = Cuti::where('user_id', $request->input('user_id'))->get();

            if ($cutiUser->isEmpty()) {
                return response()->json(['message' => 'Tidak ada cuti yang ditemukan untuk pengguna ini.'], 404);
            }

            return response()->json([
                'message' => 'Daftar cuti berhasil ditemukan.',
                'success' => true,
                'total' => $cutiUser->count(),
                'data' => $cutiUser,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil daftar cuti. Error: ' . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            // Ambil pengguna yang sedang diautentikasi
            $user = $request->user();

            // Jika pengguna tidak diautentikasi, kembalikan respons error
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Validasi input
            $request->validate([
                'user_id' => 'required',
                'cuti_id' => 'required',
            ]);

            // Hapus cuti berdasarkan ID dan ID pengguna
            $deletedCuti = Cuti::where('id', $request->input('cuti_id'))
                ->where('user_id', $request->input('user_id'))
                ->delete();

            // Jika cuti berhasil dihapus, kembalikan respons sukses
            if ($deletedCuti) {
                return response()->json(['message' => 'Cuti berhasil dihapus.'], 200);
            } else {
                // Jika cuti tidak ditemukan, kembalikan respons dengan pesan
                return response()->json(['message' => 'Cuti tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons error
            return response()->json(['error' => 'Gagal menghapus cuti. Error: ' . $e->getMessage()], 500);
        }
    }
}
