<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model
{
    protected $table='terms_condition';
    protected $fillable=['name','title','description','status','link','fk_company_id'];

    public function scopeOwnCompany($query){
        $query->where('status','1')->where('fk_company_id',auth()->user()->fk_company_id);
    }
}
