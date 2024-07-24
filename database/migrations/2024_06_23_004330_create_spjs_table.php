<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spjs', function (Blueprint $table) {
            $table->string("no",15);
            $table->string("kdDinas",26);
            $table->string("kdBidang",15);
            $table->string("taSPJ",6);
            $table->string("kdSub",25); 
            $table->string("kdJudul",15);

            $table->text("data");
            $table->string("volume",150);
            $table->string("satuan",150);
            $table->string("totVol",150);
            $table->string("totSatuan",150);
            $table->string("keterangan",250);
            $table->string("an",250)->comment('Atas Nama');
            $table->string("idMember",25)->comment('penanggung Jawab');
            $table->string("status",250)->comment('tahapan proses SPJ');
            $table->timestamps();
            $table->primary(["kdDinas","no","kdBidang","taSPJ","kdSub","kdJudul"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spjs');
    }
}
