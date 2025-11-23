<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ujian');
            $table->string('nama');
            $table->string('no_peserta');
            $table->string('nisn');
            $table->string('no_hp');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ujian')->references('id')->on('ujians');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesertas');
    }
};
