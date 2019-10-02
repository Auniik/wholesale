<?php

use Illuminate\Database\Seeder;

class ReligionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Religion::all()->each->delete();
        $relidions = [
            ['name' => 'Islam'],
            ['name' => 'Hinduism'],
            ['name' => 'Buddhism'],
            ['name' => 'Christianity'],
            ['name' => 'Sikhism'],
        ];

        foreach ($relidions as $relidion){
            \App\Models\Religion::create($relidion);
        }
    }
}
