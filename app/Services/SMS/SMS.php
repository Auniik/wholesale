<?php
namespace App\Services\SMS;

use GuzzleHttp\Client;

class SMS
{

    protected $params = [];


    public function __construct()
    {
        $this->username(config('services.sms.username'))
            ->password(config('services.sms.password'))
            ->from(config('services.sms.from'));
    }

    /** Setting api username
     * @param $username
     * @return $this
     */
    public function username($username)
    {
        $this->params['Username'] = $username;

        return $this;
    }

    /** Setting api password
     * @param $password
     * @return $this
     */
    public function password($password)
    {
        $this->params['Password'] = $password;

        return $this;
    }

    /** Setting api from
     * @param $from
     * @return $this
     */
    public function from($from)
    {
        $this->params['From'] = $from;

        return $this;
    }

    /** Setting to number|numbers
     * @param $to
     * @return $this
     */
    public function to($to)
    {
        if (is_array($to)){
            $to = implode(',', $to);
        }

        $this->params['To'] = $to;

        return $this;
    }

    /** Setting send able message
     * @param $message
     * @return $this
     */
    public function message($message)
    {
        $this->params['Message'] = $message;

        return $this;
    }

    /** Send request to send text message
     * @return \Psr\Http\Message\StreamInterface
     */
    public function send()
    {
        $client = $this->client();

        return $client->post(config('services.sms.send'), [
            'form_params' => $this->params
        ])->getBody();

    }

    /** Create Http Client
     * @return Client
     */
    protected function client()
    {
        return new Client([
            'base_uri' => config('services.sms.api')
        ]);
    }


}