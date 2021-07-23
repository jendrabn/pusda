<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsi8KelDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_8keldata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uraian_8keldata_id')->constrained('uraian_8keldata')->onDelete('cascade');
            $table->year('tahun')->nullable();
            $table->string('isi', 30)->nullable();
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
        Schema::dropIfExists('isi8_kel_data');
    }
}
