<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('board_user', function (Blueprint $table) {
          $table->integer('boards_id')->unsigned();
          $table->integer('users_id')->unsigned();

          $table->foreign('boards_id')->references('id')->on('boards')
              ->onUpdate('cascade')->onDelete('cascade');
          $table->foreign('users_id')->references('id')->on('users')
              ->onUpdate('cascade')->onDelete('cascade');

          $table->primary(['boards_id', 'users_id']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('board_user');
    }
}
