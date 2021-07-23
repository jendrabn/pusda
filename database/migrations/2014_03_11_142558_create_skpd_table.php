<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkpdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skpd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skpd_category_id')->nullable();
            $table->string('nama');
            $table->string('singkatan');
            $table->timestamps();

            $table->foreign('skpd_category_id')->references('id')->on('skpd_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skpds');
    }
}
