<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUraianRpjmdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uraian_rpjmd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('skpd_id')->nullable();
            $table->foreignId('tabel_rpjmd_id')->constrained('tabel_rpjmd')->onDelete('cascade');
            $table->string('uraian');
            $table->string('satuan')->nullable();
            $table->boolean('ketersediaan_data')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('uraian_rpjmd')->onDelete('cascade');
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
        Schema::dropIfExists('uraian_rpjmd');
    }
}
