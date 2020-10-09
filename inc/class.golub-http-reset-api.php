<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class GolubHttp
{

    public function goLubApiPost($url,array$data,array $headers)
    {

        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  $this->enCodeRequestBody($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->httpParseHeaders($headers));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    protected function httpParseHeaders(array $raw_headers)
    {
        $raw_headers_out_put = array();
        foreach ($raw_headers as $raw_header_key => $raw_header_value){
            $key_value_pair =$raw_header_key.':'.$raw_header_value;
            array_push($raw_headers_out_put,$key_value_pair);
        }
        return $raw_headers_out_put;
    }

    protected function enCodeRequestBody(array $body)
    {
        return json_encode($body);
    }

    public function goLubApiReponseBody($body)
    {
        return $this->decodeResponseBody($body);
    }

    protected function decodeResponseBody($body)
    {
        return json_decode($body,true);
    }


}
