<?php

use Illuminate\Database\Seeder;

class EmployeeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EmployeeCategory::all()->each->delete();
        $categories = [
            ['name' => 'Clinical Doctor'],
            ['name' => 'Non-Clinical Doctor'],
            ['name' => 'Employee'],
        ];

        foreach ($categories as $category){
            \App\Models\EmployeeCategory::create($category);
        }
    }
}
