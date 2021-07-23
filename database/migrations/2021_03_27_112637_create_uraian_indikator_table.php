<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUraianIndikatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uraian_indikator', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('skpd_id')->nullable();
            $table->foreignId('tabel_indikator_id')->constrained('tabel_indikator')->onDelete('cascade');
            $table->string('uraian');
            $table->string('satuan', 30)->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('uraian_indikator')->onDelete('cascade');
            $table->foreign('skpd_id')->references('id')->on('skpd')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uraian_indikator');
    }
}
