<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ujians')->insert([
            'nama_ujian' => 'STS Ganjil 2024/2025',
            'semester' => 'Ganjil',
            'tahun_pelajaran' => '2024/2025',
            'status' => true,
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);
    }
}
