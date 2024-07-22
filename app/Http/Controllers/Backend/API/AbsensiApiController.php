<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AktifKoordinat;
use App\Models\Izin;
use App\Models\Dinas;
use App\Models\Cuti;
use App\Models\Sakit;
use App\Models\User;
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

        // Mencari data berdasarkan ID pengguna dan membatasi hasilnya menjadi 10 berdasarkan tanggal
        $absensi = Absensi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc') // Menampilkan data terbaru dulu
            ->limit(3)
            ->get();

        return response()->json(['data' => $absensi]);
    }

    public function riwayatPresensi(Request $request)
    {
        $userId = $request->input('user_id');

        // Mencari data absensi berdasarkan ID pengguna dan membatasi hasilnya menjadi 2 berdasarkan tanggal
        $absensi = Absensi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc') // Menampilkan data terbaru dulu
            ->limit(2)
            ->get();

        // Mencari data sakit berdasarkan ID pengguna dan membatasi hasilnya menjadi 2 berdasarkan tanggal
        $sakit = Sakit::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->limit(2)
            ->get();

        // Mencari data dinas berdasarkan ID pengguna dan membatasi hasilnya menjadi 2 berdasarkan tanggal
        $dinas = Dinas::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->limit(2)
            ->get();

        // Mencari data cuti berdasarkan ID pengguna dan membatasi hasilnya menjadi 2 berdasarkan tanggal_mulai
        $cuti = Cuti::where('user_id', $userId)
            ->orderBy('tanggal_mulai', 'desc')
            ->limit(2)
            ->get();

        // Mencari data izin berdasarkan ID pengguna dan membatasi hasilnya menjadi 2 berdasarkan tanggal
        $izin = Izin::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->limit(2)
            ->get();

        // Menggabungkan semua data
        $data = [
            'absensi' => $absensi,
            'sakit' => $sakit,
            'dinas' => $dinas,
            'cuti' => $cuti,
            'izin' => $izin,
        ];

        return response()->json(['data' => $data]);
    }

    public function report(Request $request)
    {
        $userId = $request->input('user_id');

        // Mencari data berdasarkan ID pengguna dan membatasi hasilnya menjadi 10 berdasarkan tanggal
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

        $pegawai = User::find($user);

        if ($pegawai->status == 'Suspend') {
            return response()->json(
                [

                    'error_type' =>'suspend',
                    'message' => 'Anda tidak diizinkan melakukan presensi karena status Anda ditangguhkan.',
                ],
                403
            );
        }
        // Jika belum ada izin atau absen masuk untuk pengguna pada tanggal yang sama, simpan absen masuk
        $jamMasuk = Carbon::now('Asia/Jakarta');
        $absensi = new Absensi([
            'user_id' => $user,
            'opd_id' => $pegawai->opd_id,
            'jabatan_id' => $pegawai->jabatan_id,
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
        $tanggalSekarang = Carbon::now('Asia/Jakarta')->toDateString();
        $tanggalKemarin = Carbon::yesterday('Asia/Jakarta')->toDateString();

        $isPiket = User::find($user)->is_piket;

        if ($isPiket == 1) {
            // Cari absen masuk terakhir untuk petugas piket yang belum memiliki jam keluar, diprioritaskan hari ini, lalu kemarin
            $absenMasuk = Absensi::where('user_id', $user)
                ->whereIn('tanggal', [$tanggalSekarang, $tanggalKemarin])
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam_masuk', 'desc')
                ->first();

            if ($absenMasuk) {
                if ($absenMasuk->jam_keluar === null) {
                    // Perbarui absen masuk dengan informasi absen keluar jika jam_keluar adalah null
                    $absenMasuk->jam_keluar = $jamKeluar;
                    $absenMasuk->save();

                    return response()->json(['message' => 'Absen keluar berhasil disimpan']);
                } else {
                    // Buat absen keluar baru dengan tanggal hari ini jika jam_keluar tidak null
                    $absenMasuk->jam_keluar = $jamKeluar;
                    $absenMasuk->save();

                    return response()->json(['message' => 'Absen keluar berhasil disimpan']);
                }
            } else {
                return response()->json(['error_type' => 'no_absen_masuk', 'message' => 'Silahkan lakukan absensi masuk piket terlebih dahulu'], 400);
            }
        } else {
            $absenMasuk = Absensi::where('user_id', $user)
                ->where('tanggal', $tanggalSekarang)
                ->first();

            if ($absenMasuk) {
                // Perbarui absen masuk dengan informasi absen keluar
                $absenMasuk->jam_keluar = $jamKeluar;
                $absenMasuk->save();

                return response()->json(['message' => 'Absen keluar berhasil disimpan']);
            } else {
                return response()->json(['message' => 'Silahkan lakukan absensi masuk terlebih dahulu'], 400);
            }
        }
    }

    public function koordinatTambahan(Request $request)
    {
        // Ambil data Coordinate terbaru
        $coordinate = AktifKoordinat::latest()->first(); // Anggap model ini adalah Coordinate

        // Ambil nilai active
        $toggleStatus = $coordinate->active ? 1 : 0;

        // Jika active (true)
        if ($toggleStatus == 1) {
            // Koordinat Kantor Bupati Pasaman
            return response()->json([
                'success' => true,
                'message' => 'Data Koordinat Berhasil Ditampilkan',
                'latitude' => 0.14050633473117458,
                'longitude' => 100.16708799628992,
            ]);
        }
        // Jika tidak active (false)
        else {
            // Koordinat Sentosa Island
            return response()->json([
                'success' => false,
                'message' => 'Data Koordinat Gagal Ditampilkan',
                'latitude' => 1.2488342315929606,
                'longitude' => 103.83065892464833,
            ]);
        }
    }
}
