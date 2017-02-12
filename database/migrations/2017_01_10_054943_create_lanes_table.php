<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('lanes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->nullable();
          $table->timestamps();
          $table->integer('board_id')->unsigned();
          $table->foreign('board_id')->references('id')->on('boards')
              ->onUpdate('cascade')->onDelete('cascade');
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::drop('lanes');
    }
}
