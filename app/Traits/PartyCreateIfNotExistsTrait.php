<?php


namespace App\Traits;


use App\Models\Party;

trait PartyCreateIfNotExistsTrait
{
    /*
     * Checking Patient Added or not,
     * If patient already exist then it will skip,
     * Separated 'patient_id number' as 'patient_id_no' and foreign key(patient_id) in this(sales) table.
     * Cause naming convention like FK_FOREIGN_KEY sucks xD
     */
    public function getParty($party_id)
    {
        if (!$party_id){
            $data['name'] =  $this->get('party_name');
            return Party::create($data)->id;
        }
        return $party_id;
    }

}