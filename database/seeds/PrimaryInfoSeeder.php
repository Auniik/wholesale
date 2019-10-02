<?php

use Illuminate\Database\Seeder;

class PrimaryInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\PrimaryInfo::create([
            'company_name' => 'Demo Hospital Ltd',
            'logo' => 'https://via.placeholder.com/180x60',
            'address' => 'Address Here',
            'mobile_no' => '1121221',
            'email' => 'update@me.com',
            'description' => 'This description'
        ]);


    }
}
