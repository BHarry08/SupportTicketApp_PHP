<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades;
class StatusMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert(
            [
                'slug' => "pending",
                'status' => "Pending",
            ]
        );

        DB::table('status')->insert(
            [
                'slug' => "inprocess",
                'status' => "In Process",
            ]
        );

        DB::table('status')->insert(
            [
                'slug' => "closed",
                'status' => "Closed",
            ]
        );
    }
}
