<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => Str::random(10),
            'emails' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'city' => "Pune",
            'state' => "Maharashtra",
            'zip' => Str::random(6),
            'phone' => Str::random(10),
            'role' => "user",
        ]);
    }
}
