<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class AdaDialogSmsApi
{
    protected $base_url = 'https://digitalreachapi.dialog.lk/';
    protected $send_sms_url = 'camp_req.php';
    protected $api_authentication_url = 'refresh_token.php';
    /**
     * @var false|mixed|void
     */
    private $sms_service;
    /**
     * @var false|mixed|void
     */
    private $user_name;
    /**
     * @var false|mixed|void
     */
    private $password;
    /**
     * @var false|mixed|void
     */
    private $token_key;
    /**
     * @var false|mixed|void
     */
    private $mt_port;

    public function __construct()
    {
        $this->sms_service = get_option('golub_api_options_sms_carrier');
        $this->user_name = get_option('golub_api_options_sms_user_name');
        $this->password = get_option('golub_api_options_sms_user_password');
        $this->mt_port = get_option('golub_api_options_text_masking');
    }


    /**
     * @param $start_time
     * @param $end_time
     * @param $customer_number
     * @param $message
     * Send Golub Sms Request
     */
    public function golubSendAdaMessageReuqest($start_time, $end_time, $customer_number, $message)
    {
        try {
            $authentication = $this->apiAuthentication();
            $http = new GolubHttp();

            return $http->goLubApiPost($this->getSendSmsUrl(), $this->sendSmsData($customer_number, $message, $start_time, $end_time), $this->sendSmsHeader($authentication));
        } catch (\Exception $exception) {
            $logger = new WC_Logger();
            $message = $exception.'@at golubSendAdaMessage Request';
            $logger->add('new-woocommerce-log-name', $message);
        }
    }

    /**
     * Api Authentication
     */
    private function apiAuthentication()
    {
        $dialog__ada_token = get_transient('golub_ada_dialog_token');
        if (false == $dialog__ada_token) {
            $http = new GolubHttp();
            $request = $http->goLubApiPost($this->getApiAuthenticationUrl(), $this->authenticationData(), $this->apiAuthenticationHeaders());
            $token = $http->goLubApiReponseBody($request);
            set_transient('golub_ada_dialog_token', $token, HOUR_IN_SECONDS);

            return  $token['access_token'];
        }

        return  $dialog__ada_token['access_token'];
    }

    /**
     * Header For Api Authentication Request
     * @return string[]
     */
    private function apiAuthenticationHeaders()
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ];
    }

    /**
     * @param $token
     * @return array
     *Sending Golub Sms Header
     */
    private function sendSmsHeader($token)
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => $token,
        ];
    }

    /**
     * @return array
     * Authentication Data
     */
    private function authenticationData()
    {
        return [
            'u_name' => $this->user_name,
            'passwd' => $this->password,
        ];
    }

    /**
     * @param $customer_number
     * @param $message
     * @param $start_time
     * @param $end_time
     * @return array
     * Sms Data for the request
     */
    protected function sendSmsData($customer_number, $message, $start_time, $end_time)
    {
        return array(
             "msisdn" => $customer_number,
             "channel" => "1",
             "mt_port" => $this->mt_port,
             "s_time" => $start_time,
             "e_time" => $end_time,
             "msg" => $message,
         );
    }
    /**
     * @param $base_url
     * @return $this
     * Set thie Base Url
     */
    protected function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;

        return $this;
    }

    /**
     * @return string
     * Get the Base Url
     */
    protected function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * @param $token_url
     * Set the Token Url
     */
    protected function setApiAuthenticationUrl($token_url)
    {
        $this->api_authentication_url = $token_url;
    }

    /**
     * @return string
     * Get Method For api authentication
     */
    protected function getApiAuthenticationUrl()
    {
        return $this->base_url.$this->api_authentication_url;
    }
    /**
     * Set the Api Url
     * @param $api_url
     * @return $this
     */
    protected function setSendSmsUrl($api_url)
    {
        $this->send_sms_url = $api_url;

        return $this;
    }

    /**
     * @return string
     * Get the Api Url
     */
    private function getSendSmsUrl()
    {
        return $this->base_url.$this->send_sms_url;
    }
}
