<?php

namespace App\Traits;


use App\Http\Requests\SMS\SMSRequest;
use App\Models\SmsTemplate;

trait SendSMSIfChecked
{

    public function sendSMS($appointment)
    {
        $template = SmsTemplate::where('company_id', company_id())->first();

        $sendConfirmation = new SMSRequest();
        return $sendConfirmation->configCheckAndSend($appointment->patient->mobile_number,
            $template->outdoorConfirmation($appointment));

    }

}