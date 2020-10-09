<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class GolubActionsTrigger
{

    /**
     * @var false|mixed|void
     */
    private $sms_service;
    /**
     * @var false|mixed|void
     */

    public function __construct()
    {
        $this->sms_service = get_option('golub_api_options_sms_carrier');
    }

    /**
     * @param $order_id
     */
    public function SendGolubWCProcessingAlertToCustomer($order_id)
    {
         $this->GolubSendSms($order_id, 'processing');

    }

    /**
     * @param $order_id
     * @param $status
     * @todo Validate the Customer number is from lkr or other country
     */
    private function GolubSendSms($order_id, $status)
    {
        $order_details = new WC_Order($order_id);
        $message = $this->defaultOrderProcessingSms($order_id, 'Processing');
        $customer_phone_number =$this->reformatPhoneNumbers($order_details->get_billing_phone());
        $ada_dialog = new AdaDialogSmsApi();
        $ada_dialog->golubSendAdaMessageReuqest($this->getSmsStartDate(),$this->getSmsEndDate($this->getSmsStartDate()),$customer_phone_number,$message);
    }


    private function getSmsStartDate()
    {
        return $start_date = date("Y-m-d H:i:s");
    }

    private function getSmsEndDate($start_date)
    {
        try {
            return date_format(date_add(new DateTime($start_date), date_interval_create_from_date_string('1 days')),
                "Y-m-d H:i:s");
        } catch (\Exception $e) {
            $logger =new WC_Logger();
            $message =  $e.'@at getSmsEndDate';
            $logger->add('new-woocommerce-log-name',$message);
        }
    }

    private function defaultOrderProcessingSms($order_id, $order_status, $shop_name = null)
    {
        $shop_name = get_bloginfo('name');

        return 'Your order '.'#'.$order_id.' is now.'.$order_status.'. '.'Thank you for shopping at '.$shop_name.'.';
    }

    public static function reformatPhoneNumbers($value)
    {
        $number = preg_replace("/[^0-9]/", "", $value);
        if (strlen($number) == 9) {
            $number = "94" . $number;
        } elseif (strlen($number) == 10 && substr($number, 0, 1) == '0') {
            $number = "94" . ltrim($number, "0");
        } elseif (strlen($number) == 12 && substr($number, 0, 3) == '940') {
            $number = "94" . ltrim($number, "940");
        }

        return $number;
    }
}
