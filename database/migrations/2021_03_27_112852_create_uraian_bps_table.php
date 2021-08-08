<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUraianBpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('uraian_bps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('skpd_id')->nullable();
            $table->foreignId('tabel_bps_id')->constrained('tabel_bps')->onDelete('cascade');
            $table->string('uraian');
            $table->string('satuan', 30)->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('uraian_bps')->onDelete('cascade');
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
        Schema::dropIfExists('uraian_bps');
    }
}
