<?php

namespace App\Http\Requests\SMS;

use App\Models\SmsConfig;
use App\Services\SMS\Facades\SMS;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class SMSRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'numbers' => 'required',
            'message' => 'required|max:640'
        ];
    }

    public function configCheckAndSend($numbers, $message, $companyId = null)
    {
        $config = $this->config($companyId);

        if ($config){
            if(decrypt($config->sms_quantity ) <= 0){
                return back()->with('error','You do not have enough sms.');
            }
            $this->sendNow($config, $numbers, $message);
        }
    }


    private function sendNow($config, $toNumbers, $text)
    {
        SMS::from(decrypt($config['masking_name']))
            ->to($toNumbers)
            ->username(decrypt($config['user_name']))
            ->password(decrypt($config['user_password']))
            ->message($text)
            ->send();

        $message = ceil(strlen($text)/160);
        $number_qty = count(explode(',',$toNumbers));
        $sms_quantity = ceil($message * $number_qty);
        $config->update([
            'sms_quantity' => encrypt(decrypt($config->sms_quantity) - $sms_quantity),
        ]);
    }

    public function config($companyId)
    {
        if (App::runningInConsole()){
            return SmsConfig::where('company_id', $companyId)->first();
        }

        return SmsConfig::where('company_id', company_id())->first();
    }


}
