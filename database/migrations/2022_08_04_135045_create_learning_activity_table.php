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
        Schema::create('ac_tahun', function (Blueprint $table) {
            $table->id('id_thn');
            $table->year('nm_tahun');
            $table->string('deskripsi', 50);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('ac_metode', function (Blueprint $table) {
            $table->id('id_mtd');
            $table->unsignedBigInteger('id_thn');
            $table->foreign('id_thn')->references('id_thn')->on('ac_tahun')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('nm_metode', 100);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('ac_bulan', function (Blueprint $table) {
            $table->id('id_bln');
            $table->string('nm_bulan', 100);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('ac_aktifitas', function (Blueprint $table) {
            $table->id('id_akt');
            $table->unsignedBigInteger('id_mtd');
            $table->foreign('id_mtd')->references('id_mtd')->on('ac_metode')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('id_thn');
            $table->foreign('id_thn')->references('id_thn')->on('ac_tahun')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('id_bln');
            $table->foreign('id_bln')->references('id_bln')->on('ac_bulan')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('acara', 100);
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->enum('status', ['Berlangsung', 'Selesai', 'Akan Datang']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ac_aktifitas');
        Schema::dropIfExists('ac_bulan');
        Schema::dropIfExists('ac_metode');
        Schema::dropIfExists('ac_tahun');
    }
};
