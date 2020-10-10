<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class GolubHttp
{
    /**
     * @param $url
     * @param array $data
     * @param array $headers
     * @return bool|string
     * Go Lub Api Post
     */
    public function goLubApiPost($url, array$data, array $headers)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  $this->enCodeRequestBody($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->httpParseHeaders($headers));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * @param array $raw_headers
     * @return array
     * Add Http Parse Headers
     */
    protected function httpParseHeaders(array $raw_headers)
    {
        $raw_headers_out_put = [];
        foreach ($raw_headers as $raw_header_key => $raw_header_value) {
            $key_value_pair = $raw_header_key.':'.$raw_header_value;
            array_push($raw_headers_out_put, $key_value_pair);
        }

        return $raw_headers_out_put;
    }

    /**
     * @param array $body
     * @return false|string
     * Add En Code Request Body
     */
    protected function enCodeRequestBody(array $body)
    {
        return json_encode($body);
    }

    /**
     * @param array $body
     * @return false|string
     * Add Golub Api Response Body
     */
    public function goLubApiReponseBody($body)
    {
        return $this->decodeResponseBody($body);
    }

    /**
     * @param array $body
     * @return false|string
     * Add DecodeResponseBody
     */
    protected function decodeResponseBody($body)
    {
        return json_decode($body, true);
    }
}
