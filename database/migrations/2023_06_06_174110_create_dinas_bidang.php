<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDinasBidang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dinas_bidang', function (Blueprint $table) {
            $table->string('kdDBidang',15);
            $table->string('kdDinas',25);
            $table->string('nmBidang',150);
            $table->string('asBidang',50);
            $table->timestamps();
            $table->primary(['kdDBidang','kdDinas']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dinas_bidang');
    }
}
