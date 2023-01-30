<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUraian8KelDataTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('uraian_8keldata', function (Blueprint $table) {
      $table->id();
      $table->foreignId('parent_id')->nullable()->constrained('uraian_8keldata')->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('skpd_id')->nullable()->constrained('skpd')->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('tabel_8keldata_id')->constrained('tabel_8keldata')->onDelete('cascade')->onUpdate('cascade');
      $table->string('uraian');
      $table->string('satuan')->nullable();
      $table->boolean('ketersediaan_data')->nullable();
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
    Schema::dropIfExists('uraian8_kel_data');
  }
}
