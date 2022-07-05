<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 0;
        while($count < 5){
            DB::table('users')->insert([
                'name' => Str::random(10),
                'emails' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password'),
                'city' => "Pune",
                'state' => "Maharashtra",
                'zip' => Str::random(6),
                'phone' => Str::random(10),
                'role' => "user",
            ]);
            $count++;
        }
    }
}
