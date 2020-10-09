<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class AdaDialogSmsApi{

    protected $base_url = 'https://digitalreachapi.dialog.lk/';
    protected $api_url = 'refresh_token.php';
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

    public function __construct()
    {
        $this->sms_service = get_option('golub_api_options_sms_carrier');
        $this->user_name = get_option('golub_api_options_sms_user_name');
        $this->password = get_option('golub_api_options_sms_user_password');
    }


    public function golubSendAdaMessageReuqest($start_time,$end_time,$customer_number,$message)
    {
            return $this->apiAuthentication();
    }

    /**
     * Api Authentication
     */

    private function apiAuthentication()
    {
        $dialog__ada_token = get_transient( 'golub_ada_dialog_token' );
        if (false == $dialog__ada_token){
            $http =new GolubHttp();
            $request = $http->goLubApiPost($this->getApiAuthenticationUrl(),$this->authenticationData(),$this->apiAuthenticationHeaders());
            $token = $http->goLubApiReponseBody($request);
            set_transient('golub_ada_dialog_token',$token,HOUR_IN_SECONDS);
            return  $token;
        }
        return  $dialog__ada_token;
    }


    private function apiAuthenticationHeaders()
    {
        return array(
            "Content-Type" =>"application/json",
            "Accept" =>"application/json",
        );
    }

    /**
     * @return array
     * Authentication Data
     */
    private function authenticationData()
    {
        return array(
            'u_name' => $this->user_name,
            'passwd' => $this->password,
        );

    }


    /**
     * @param $base_url
     * @return $this
     * Set thie Base Url
     */
    protected function setBaseUrl($base_url){
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

    protected function getApiAuthenticationUrl()
    {
        return $this->base_url.$this->api_authentication_url;
    }
    /**
     * Set the Api Url
     * @param $api_url
     * @return $this
     */
    protected function setApiUrl($api_url)
    {
        $this->api_url = $api_url;
        return $this;
    }

    /**
     * @return string
     * Get the Api Url
     */
    private function getApiUrl()
    {
        return $this->api_url;
    }

}
