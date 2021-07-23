<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiturRpjmdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fitur_rpjmd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tabel_rpjmd_id')->constrained('tabel_rpjmd')->onDelete('cascade');
            $table->text('deskripsi')->nullable();
            $table->text('analisis')->nullable();
            $table->text('permasalahan')->nullable();
            $table->text('solusi')->nullable();
            $table->text('saran')->nullable();
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
        Schema::dropIfExists('fitur_rpjmds');
    }
}
