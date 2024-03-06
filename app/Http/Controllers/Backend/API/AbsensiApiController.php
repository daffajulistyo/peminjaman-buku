<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Dinas;
use App\Models\Cuti;
use App\Models\Sakit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AbsensiApiController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['generatePDF']]);
    }

    public function index()
    {
        $absensi = Absensi::all();

        return response()->json(['data' => $absensi]);
    }

    public function findName(Request $request)
    {
        $userId = $request->input('user_id');

        $absensi = Absensi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc') // Menampilkan data terbaru dulu
            ->limit(2)
            ->get(); 

        return response()->json(['data' => $absensi]);
    }

    public function report(Request $request)
    {
        $userId = $request->input('user_id');

        $absensi = Absensi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc') // Menampilkan data terbaru dulu
            ->get();

        return response()->json(['data' => $absensi]);
    }

    public function store(Request $request)
    {
        // Memeriksa apakah 'user_id' ada dalam request
        if (!$request->has('user_id') || $request->input('user_id') === null) {
            return response()->json(['message' => 'User Id Harus Diisi'], 400);
        }

        $user = $request->input('user_id');
        $tanggal = Carbon::now('Asia/Jakarta')->toDateString();


        $izinExist = Izin::where('user_id', $user)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($izinExist) {
            return response()->json(['error_type' => 'izin_exist', 'message' => 'Anda memiliki izin pada tanggal ini.'], 400);
        }

        $dinasExist = Dinas::where('user_id', $user)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($dinasExist) {
            return response()->json(['error_type' => 'dinas_exist', 'message' => 'Anda sedang dinas pada tanggal ini.'], 400);
        }

        $sakitExist = Sakit::where('user_id', $user)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($sakitExist) {
            return response()->json(['error_type' => 'sakit_exist', 'message' => 'Anda sedang sakit pada tanggal ini.'], 400);
        }

        $cutiExist = Cuti::where('user_id', $user)
            ->where('tanggal_mulai', '<=', $tanggal)
            ->where('tanggal_selesai', '>=', $tanggal)
            ->exists();

        if ($cutiExist) {
            return response()->json(['error_type' => 'cuti_exist', 'message' => 'Anda sedang cuti pada tanggal ini.'], 400);
        }

        $existingAbsen = Absensi::where('user_id', $user)
            ->where('tanggal', $tanggal)
            ->first();

        if ($existingAbsen) {
            return response()->json(['message' => 'Anda sudah melakukan absen masuk hari ini']);
        }

        $jamMasuk = Carbon::now('Asia/Jakarta');
        $absensi = new Absensi([
            'user_id' => $user,
            'tanggal' => $tanggal,
            'jam_masuk' => $jamMasuk->toTimeString(),
        ]);
        $absensi->save();

        return response()->json(['message' => 'Absensi berhasil disimpan']);
    }

    public function storeKeluar(Request $request)
    {
        $user = $request->input('user_id');
        $jamKeluar = Carbon::now('Asia/Jakarta')->toTimeString();

        $absenMasuk = Absensi::where('user_id', $user)
            ->where('tanggal', Carbon::now('Asia/Jakarta')->toDateString())
            ->first();

        if ($absenMasuk) {
            $absenMasuk->jam_keluar = $jamKeluar;
            $absenMasuk->save();

            return response()->json(['message' => 'Absen keluar berhasil disimpan']);
        } else {
            $jamMasuk = null; // Sesuaikan dengan cara Anda menyimpan data jam masuk
            $absenKeluar = new Absensi([
                'user_id' => $user,
                'tanggal' => Carbon::now('Asia/Jakarta')->toDateString(),
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
            ]);
            $absenKeluar->save();

            return response()->json(['message' => 'Absen keluar berhasil disimpan']);
        }
    }
}
