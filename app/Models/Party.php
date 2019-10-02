<?php

namespace App\Models;

use App\Traits\ManageCompanyIdCreatedByUpdatedByTraits;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use ManageCompanyIdCreatedByUpdatedByTraits;
    protected $fillable = [
        'company_id', 'created_by', 'updated_by', 'name', 'telephone', 'mobile_number', 'email', 'status',
        'contact_person_name', 'contact_person_designation', 'contact_person_department', 'contact_person_telephone',
        'contact_person_mobile', 'address'
    ];
}
