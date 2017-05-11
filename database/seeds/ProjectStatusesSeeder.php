<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('board_statuses')->truncate();
        DB::table('board_statuses')->insert(
            [
                ['id' => 1, 'name' => "open"],
                ['id' => 2, 'name' => "close"]
            ]

    );

    }
}
