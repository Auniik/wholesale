<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $isSystemAdmin = Role::with('permissions')->where('name', 'System Admin')->first();
        $isAdmin = Role::with('permissions')->where('name', 'Admin')->first();
        if (!$isAdmin || !$isSystemAdmin){
            $admin_roles = [
                ['name' => 'System Admin'],
                ['name' => 'Admin'],
            ];
            foreach ($admin_roles as $role){
                Role::create($role)->permissions()->sync(\App\Models\Permission::pluck('id')->toArray());
            }
        }else{
            $isSystemAdmin->permissions()->sync(\App\Models\Permission::pluck('id')->toArray());
            $isAdmin->permissions()->sync(\App\Models\Permission::pluck('id')->toArray());
        }
        $isEmployee = Role::where('name', 'Employee')->first();
        if (!$isEmployee){
            Role::create([
                'name' => 'Employee'
            ]);
        }
    }
}
