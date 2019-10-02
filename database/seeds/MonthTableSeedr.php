<?php

use Illuminate\Database\Seeder;

class MonthTableSeedr extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Month::all()->each->delete();
        $nameOrDays = [
            [
                'month_name' => 'January',
                'days' => '31'
            ],
            [
                'month_name' => 'February',
                'days' => '28'
            ],
            [
                'month_name' => 'March',
                'days' => '31'
            ],
            [
                'month_name' => 'April',
                'days' => '30'
            ],
            [
                'month_name' => 'May',
                'days' => '31'
            ],
            [
                'month_name' => 'June',
                'days' => '30'
            ],
            [
                'month_name' => 'July',
                'days' => '31'
            ],
            [
                'month_name' => 'August',
                'days' => '31'
            ],
            [
                'month_name' => 'September',
                'days' => '30'
            ],
            [
                'month_name' => 'October',
                'days' => '31'
            ],
            [
                'month_name' => 'November',
                'days' => '30'
            ],
            [
                'month_name' => 'December',
                'days' => '31'
            ],
        ];

        foreach ($nameOrDays as $name){
            App\Month::create($name);
        };
    }
}
