<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work', function (Blueprint $table) {
            $table->text('maksud')->default('');
            $table->string('angkut',100)->default('');
            $table->string('tempatS',100)->default('Taliwang');
            $table->string('tempatE',100)->default('');
            $table->string('dateE',25)->default('');
            $table->string('anggaran',100)->default('');
            $table->string('keterangan',100)->default('');
            $table->string('lokasi',100)->default('');
            $table->string('dasar')->default('');
            $table->string('fileD')->default('')->comment('dasar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work', function (Blueprint $table) {
            //
        });
    }
}
