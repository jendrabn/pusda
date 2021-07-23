<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsiIndikatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_indikator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uraian_indikator_id')->constrained('uraian_indikator')->onDelete('cascade');
            $table->year('tahun')->nullable();
            $table->string('isi',30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('isi_indikators');
    }
}
