<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientHistoryResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        static::$wrap = null;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'patient_id' => $this->patient_id,
            'age' => $this->age,
            'mobile_number' => $this->mobile_number,
            'sex' => sex($this->sex),
            'prescriptions' => $this->prescriptions->map(function ($prescription){
                return [
                    'id' => $prescription->id,
                    'date' => $prescription->date->format('d/m/Y')
                ];
            }),
            'service_sales' => $this->serviceSales->map(function ($service){
                return [
                    'id' => $service->id,
                    'date' => $service->invoice_date->format('d/m/Y')
                ];
            })
        ];
    }
}
