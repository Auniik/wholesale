<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class CompanyListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $company = $this->createCompany();

        $role = $this->initialRoles();

        if ($company){
            $this->createSuperAdmin($company->id, $role['systemAdmin']);

            $this->createAdmin($company->id, $role['admin']);
        }


    }

    private function createAdmin($companyId, $admin)
    {
        $user = \App\User::where([
            ['name', 'Administrator']
        ])->first();

        if(!$user){
            return \App\User::create([
                'name' => 'Administrator',
                'email' => 'email@email.com',
                'password' => bcrypt(123456),
                'phone_number' => '01785464554',
                'address' => 'Panthapath, Dhaka',
                'type' => '1',
                'status' => '1',
                'created_by' => '1',
                'fk_company_id' => $companyId,
                'branch_id' => 1,
                'role_id' => $admin
            ]);
        }
    }

    private function createSuperAdmin($companyId, $systemAdmin)
    {
        $user = \App\User::where([
            ['name', 'System Admin']
        ])->first();

        if (!$user){
            return \App\User::create([
                'name' => 'System Admin',
                'email' => 'admin@smartsoft.com',
                'password' => bcrypt(123456),
                'phone_number' => '017systemAdmin',
                'address' => 'Dhaka',
                'type' => '1',
                'status' => '1',
                'created_by' => '1',
                'fk_company_id' => $companyId,
                'branch_id' => 1,
                'role_id' => $systemAdmin
            ]);
        }

    }

    private function createCompany()
    {
//        \App\Models\CompanyList::all()->each->delete();
        $company = \App\Models\CompanyList::where('company_name', 'Democratic Diagnostic Center')->first();

        if (!$company){
            return \App\Models\CompanyList::create([
                'company_name' => 'Democratic Diagnostic Center',
                'mobile_no' => '01554551545',
                'email' => 'email@email.com',
                'fax' => '54-545545',
                'web' => 'https://www.facebook.com/auniikq',
                'status' => 1,
                'bank_name' => 'Clinical Name',
                'account_no' => '187846579766',
                'branch_name' => 'Nostk Road',
                'swift' => '14575',
                'routing_no' => '1212'
            ]);
        }
    }

    private function initialRoles()
    {
        $systemAdmin = Role::with('permissions')->where('name', 'System Admin')->first();
        if(!$systemAdmin){
            $systemAdmin = Role::create(['name'=>'System Admin']);
        }
        $systemAdmin->permissions()->sync(\App\Models\Permission::pluck('id')->toArray());


        $admin = Role::with('permissions')->where('name', 'Admin')->first();
        if(!$admin){
            $admin = Role::create(['name'=>'Admin']);
        }
        $admin->permissions()->sync(\App\Models\Permission::pluck('id')->toArray());

        $isEmployee = Role::where('name', 'Employee')->first();

        if (!$isEmployee){
            Role::create([
                'name' => 'Employee'
            ]);
        }

        return [
            'systemAdmin' => $systemAdmin->id,
            'admin' => $admin->id,
        ];
    }


}
