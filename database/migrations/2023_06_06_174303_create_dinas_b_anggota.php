<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDinasBAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dinas_b_anggota', function (Blueprint $table) {
            $table->string('kdBAnggota',15);
            $table->string('kdBidang',15);
            $table->string('kdDinas',25);
            $table->string('nmAnggota',150);
            $table->string('nmJabatan',50);
            $table->string('nip',50);
            $table->string('status',50);
            $table->timestamps();
            $table->primary(['kdBAnggota','kdBidang','kdDinas']);
        });
    }

    /** status -> pimpinan,bendahara,lainnya
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dinas_b_anggota');
    }
}
