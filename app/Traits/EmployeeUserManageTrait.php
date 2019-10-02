<?php

namespace App\Traits;


use App\Models\Role;
use App\User;

trait EmployeeUserManageTrait
{
    public function createUser()
    {
        return User::create([
            'name'=> $this->name,
            'email'=> $this->email,
            'password'=> bcrypt(123456),
            'phone_number'=> $this->phone,
            'address' => $this->present_address,
            'type' => 0,
            'role_id' => Role::whereName('Employee')->first()->id,
            'fk_company_id' => company_id(),
            'status' => 1,
            'brunch_id '=> branch_id(),
        ]);
    }

    public function update()
    {
        return User::create([
            'name'=> $this->name,
            'email'=> $this->email,
            'password'=> bcrypt(123456),
            'phone_number'=> $this->phone,
            'address' => $this->present_address,
            'type' => 0,
            'role_id' => Role::whereName('Employee')->first()->id,
            'fk_company_id' => company_id(),
            'status' => 1,
            'brunch_id '=> branch_id(),
        ]);
    }
}
