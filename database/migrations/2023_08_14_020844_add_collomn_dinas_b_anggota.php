<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollomnDinasBAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dinas_b_anggota', function (Blueprint $table) {
            $table->string("asJabatan",50);
            $table->string("golongan",50);
            $table->string("tingkatan",5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dinas_b_anggota', function (Blueprint $table) {
            //
        });
    }
}
