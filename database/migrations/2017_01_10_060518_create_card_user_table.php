<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('card_user', function (Blueprint $table) {
          $table->integer('cards_id')->unsigned();
          $table->integer('users_id')->unsigned();

          $table->foreign('cards_id')->references('id')->on('cards')
              ->onUpdate('cascade')->onDelete('cascade');
          $table->foreign('users_id')->references('id')->on('users')
              ->onUpdate('cascade')->onDelete('cascade');

          $table->primary(['cards_id', 'users_id']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('card_user');
    }
}
