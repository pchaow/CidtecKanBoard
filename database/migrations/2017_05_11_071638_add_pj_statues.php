<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPjStatues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_statuses', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name')->nullable();
            $table->timestamps();

            $table->primary('id');
        });

        Schema::table('boards', function (Blueprint $table) {
            $table->integer('board_status_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('board_statuses');
    }
}
