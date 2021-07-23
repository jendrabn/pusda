<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFile8KelDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_8keldata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tabel_8keldata_id')->constrained('tabel_8keldata')->onDelete('cascade');
            $table->string('file_name', 100);
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
        Schema::dropIfExists('file_8keldata');
    }
}
