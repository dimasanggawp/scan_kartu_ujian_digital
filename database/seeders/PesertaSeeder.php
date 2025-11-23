<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /**
         * * Mengisi data dummy peserta ujian */
        DB::table('pesertas')->insert([
            [
                'id_ujian' => '1',
                'nama' => 'Dimas Angga Wahyu Putra',
                'no_peserta' => '1001',
                'nisn' => '1001',
                'no_hp' => '087854130104',
                'created_at' => Carbon::now('Asia/Jakarta'),
            ],
            [
                'id_ujian' => '1',
                'nama' => 'Haris Yulianto',
                'no_peserta' => '1002',
                'nisn' => '1002',
                'no_hp' => '085775621099',
                'created_at' => Carbon::now('Asia/Jakarta'),
            ],
            [
                'id_ujian' => '1',
                'nama' => 'Iranda M. Anshori',
                'no_peserta' => '1003',
                'nisn' => '1003',
                'no_hp' => '081234664710',
                'created_at' => Carbon::now('Asia/Jakarta'),
            ],
        ]);
    }
}
