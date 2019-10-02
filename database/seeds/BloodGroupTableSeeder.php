<?php

use Illuminate\Database\Seeder;

class BloodGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\BloodGroup::all()->each->delete();
        $groups = [
            ['name' => 'A+'],
            ['name' => 'O+'],
            ['name' => 'B+'],
            ['name' => 'AB+'],
            ['name' => 'A-'],
            ['name' => 'O-'],
            ['name' => 'AB-'],
        ];

        foreach ($groups as $group){
            \App\Models\BloodGroup::create($group);
        }
    }
}
