<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelRpjmdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_rpjmd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skpd_id')->constrained('skpd')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('nama_menu');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('tabel_rpjmd')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabel_rpjmds');
    }
}
