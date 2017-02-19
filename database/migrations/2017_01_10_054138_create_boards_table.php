<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('boards', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->text('description')->nullable();
          $table->timestamps();
          $table->integer('user_id')->unsigned();

          $table->foreign('user_id','boards_user_id_index')->references('id')->on('users')
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
          Schema::drop('boards');
    }
}
