<?php

use Illuminate\Database\Seeder;

class ContestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('contests')->insert([
            'name' => 'Win a Camera',
            'description' => 'Upload a amazing picture',
            'image' => '/frontend/images/contests/img2.jpg',
            'max_contestants' => 12,
            'start' => '2017-02-02',
            'end' => '2017-02-08'
        ]);
    }
}
