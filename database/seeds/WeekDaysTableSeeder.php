<?php

use Illuminate\Database\Seeder;

class WeekDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Weekdays::all()->each->delete();
        $days = [
            ['name' => 'Sunday', 'short_name' => 'Sun'],
            ['name' => 'Monday', 'short_name' => 'Mon'],
            ['name' => 'Tuesday', 'short_name' => 'Tues'],
            ['name' => 'Wednesday', 'short_name' => 'Wed'],
            ['name' => 'Thursday', 'short_name' => 'Thurs'],
            ['name' => 'Friday', 'short_name' => 'Fri'],
            ['name' => 'Saturday', 'short_name' => 'Sat'],
        ];

        foreach ($days as $day){
            \App\Models\Weekdays::create($day);
        }
    }
}
