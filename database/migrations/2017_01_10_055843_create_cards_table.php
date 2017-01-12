<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cards', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->nullable();
          $table->text('description')->nullable();
          $table->integer('lanes_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->date('startdate')->nullable();
          $table->date('duedate')->nullable();
          $table->json('checklists')->nullable();
          $table->timestamps();

          $table->foreign(['lanes_id'])->references('id')->on('lanes')
              ->onUpdate('cascade')->onDelete('cascade');
          $table->foreign('user_id')->references('id')->on('users')
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
          Schema::drop('cards');
    }
}
