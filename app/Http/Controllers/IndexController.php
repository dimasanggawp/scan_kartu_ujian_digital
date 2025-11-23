<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Peserta;
use App\Models\Presensi;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class IndexController extends Controller
{
    /**
     * * Mengembalikan tampilan index
     */
    public function index()
    {
        return view('index');
    }
    
    /**
     * * Mengembalikan tampilan pengawas
     */
    public function pengawas()
    {
        return view('pengawas');
    }

    /**
     * * Melakukan pemrosesan data yaitu memasukkan ke dalam database serta mengirim ke Google Sheets API serta Whatsapp API
     */
    public function proses($no_peserta)
    {
        /**
         * * Mengambil data ujian yang sedang aktif
         */
        $ujian = Ujian::where('status', true)->first();

        if (!$ujian) {
            return response()->json(['error' => 'Tidak ada ujian yang sedang aktif'], 404);
        }

        /**
         * * Mengambil data peserta pada ujian yang sedang aktif
         */
        $peserta = Peserta::where('no_peserta', $no_peserta)
            ->where('id_ujian', $ujian->id)
            ->first();

        if (!$peserta) {
            return response()->json(['error' => 'Peserta tidak ditemukan'], 404);
        }
        
        if(strlen($peserta->no_peserta) > 25){
            return response()->json(['error' => 'Masukkan nomor peserta ujian'], 404);
        }

        try {
            /**
             * ? Melakukan pengecekan apakah peserta ujian sudah ada dalam table presensi
             */
            $presensi = Presensi::where('id_ujian', $ujian->id)
                ->where('id_peserta', $peserta->id)
                ->firstOrFail();

            /**
             * TODO : Jika sudah ada dalam table presensi maka lakukan update pada jam pulang
             */
            $presensi->jam_pulang = Carbon::now('Asia/Jakarta');
            $presensi->save();
            
            /**
             * TODO : Mengirimkan data ke Google Form
             */
            $response_google_form = Http::asForm()->post(env('GOOGLE_FORM_URL'), [
                'usp' => 'pp_url',
                'entry.184822090' => $peserta->no_peserta,
            ]);
            
            if ($response_google_form->successful()) {
                // Handle successful response
            } else {
                // Handle error
                dd($response_google_form->body());
            }
            
            // /**
            //  * TODO : Mengirimkan data ke Google Spreadsheet
            //  */
            // $response = Http::withHeaders([
            //     'Content-Type' => 'application/json',
            // ])->post(env('APP_SCRIPT_URL'), [
            //     'timestamp' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            //     'no_ujian' => $peserta->no_peserta,
            //     'nisn' => $peserta->nisn,
            //     'nama' => $peserta->nama,
            // ]);

            /**
             * TODO : Mengirimkan data ke Whatsapp API
             */
            return response()->json([
                'data_peserta' => $peserta,
                'data_ujian' => $ujian,
                'message' => 'Peserta ' . $ujian->nama_ujian . ' atas nama ' . $peserta->nama . ' telah tercatat menyelesaikan ujian pada pukul ' . Carbon::now('Asia/Jakarta'),
            ]);
        } catch (ModelNotFoundException $e) {
            /**
             * TODO : Jika belum ada maka buat data baru dalam table presensi
             */
            Presensi::create([
                'id_peserta' => $peserta->id,
                'id_ujian' => $ujian->id,
                'jam_datang' => Carbon::now('Asia/Jakarta'),
            ]);

            // /**
            //  * TODO : Mengirimkan data ke Google Spreadsheet
            //  */
            // $response = Http::withHeaders([
            //     'Content-Type' => 'application/json',
            // ])->post(env('APP_SCRIPT_URL'), [
            //     'timestamp' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            //     'no_ujian' => $peserta->no_peserta,
            //     'nisn' => $peserta->nisn,
            //     'nama' => $peserta->nama,
            // ]);
            
            /**
             * TODO : Mengirimkan data ke Google Form
             */
            $response_google_form = Http::asForm()->post(env('GOOGLE_FORM_URL'), [
                'usp' => 'pp_url',
                'entry.184822090' => $peserta->no_peserta,
            ]);

            return response()->json([
                'data_peserta' => $peserta,
                'data_ujian' => $ujian,
                'message' => 'Peserta ' . $ujian->nama_ujian . ' atas nama ' . $peserta->nama . ' telah tercatat memulai ujian pada pukul ' . Carbon::now('Asia/Jakarta'),
            ]);
        }
    }
    
    /**
     * * Melakukan pemrosesan data yaitu memasukkan ke dalam database serta mengirim ke Google Sheets API serta Whatsapp API
     */
    public function proses_pengawas($no_peserta)
    {
        /**
         * * Mengambil data ujian yang sedang aktif
         */
        $ujian = Ujian::where('status', true)->first();

        if (!$ujian) {
            return response()->json(['error' => 'Tidak ada ujian yang sedang aktif'], 404);
        }

        /**
         * * Mengambil data peserta pada ujian yang sedang aktif
         */
        $peserta = Peserta::where('no_peserta', $no_peserta)
            ->where('id_ujian', $ujian->id)
            ->first();

        if (!$peserta) {
            return response()->json(['error' => 'Peserta tidak ditemukan'], 404);
        }
        
        if(strlen($peserta->no_peserta) < 6){
            return response()->json(['error' => 'Masukkan nomor pengawas'], 404);
        }

        try {
            /**
             * ? Melakukan pengecekan apakah peserta ujian sudah ada dalam table presensi
             */
            $presensi = Presensi::where('id_ujian', $ujian->id)
                ->where('id_peserta', $peserta->id)
                ->firstOrFail();

            /**
             * TODO : Jika sudah ada dalam table presensi maka lakukan update pada jam pulang
             */
            $presensi->jam_pulang = Carbon::now('Asia/Jakarta');
            $presensi->save();
            
            /**
             * TODO : Mengirimkan data ke Google Form
             */
            $response_google_form = Http::asForm()->post(env('GOOGLE_FORM_URL'), [
                'usp' => 'pp_url',
                'entry.184822090' => $peserta->no_peserta,
            ]);
            
            if ($response_google_form->successful()) {
                // Handle successful response
            } else {
                // Handle error
                dd($response_google_form->body());
            }
            
            // /**
            //  * TODO : Mengirimkan data ke Google Spreadsheet
            //  */
            // $response = Http::withHeaders([
            //     'Content-Type' => 'application/json',
            // ])->post(env('APP_SCRIPT_URL'), [
            //     'timestamp' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            //     'no_ujian' => $peserta->no_peserta,
            //     'nisn' => $peserta->nisn,
            //     'nama' => $peserta->nama,
            // ]);

            /**
             * TODO : Mengirimkan data ke Whatsapp API
             */
            return response()->json([
                'data_peserta' => $peserta,
                'data_ujian' => $ujian,
                'message' => 'Pengawas ' . $ujian->nama_ujian . ' atas nama ' . $peserta->nama . ' telah tercatat ke dalam sistem pada pukul ' . Carbon::now('Asia/Jakarta'),
            ]);
        } catch (ModelNotFoundException $e) {
            /**
             * TODO : Jika belum ada maka buat data baru dalam table presensi
             */
            Presensi::create([
                'id_peserta' => $peserta->id,
                'id_ujian' => $ujian->id,
                'jam_datang' => Carbon::now('Asia/Jakarta'),
            ]);

            // /**
            //  * TODO : Mengirimkan data ke Google Spreadsheet
            //  */
            // $response = Http::withHeaders([
            //     'Content-Type' => 'application/json',
            // ])->post(env('APP_SCRIPT_URL'), [
            //     'timestamp' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            //     'no_ujian' => $peserta->no_peserta,
            //     'nisn' => $peserta->nisn,
            //     'nama' => $peserta->nama,
            // ]);
            
            /**
             * TODO : Mengirimkan data ke Google Form
             */
            $response_google_form = Http::asForm()->post(env('GOOGLE_FORM_URL'), [
                'usp' => 'pp_url',
                'entry.184822090' => $peserta->no_peserta,
            ]);

            return response()->json([
                'data_peserta' => $peserta,
                'data_ujian' => $ujian,
                'message' => 'Pengawas ' . $ujian->nama_ujian . ' atas nama ' . $peserta->nama . ' telah tercatat ke dalam sistem pada pukul ' . Carbon::now('Asia/Jakarta'),
            ]);
        }
    }
}
