<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileRpjmdTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('file_rpjmd', function (Blueprint $table) {
      $table->id();
      $table->foreignId('tabel_rpjmd_id')->constrained('tabel_rpjmd')->onDelete('cascade');
      $table->string('nama');
      $table->string('path');
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
    Schema::dropIfExists('file_rpjmd');
  }
}
