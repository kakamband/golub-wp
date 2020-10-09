<?php

if ( ! defined( 'ABSPATH' ) ) {
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

    public function SendGolubWCProcessingAlertToCustomer($order_id)
    {

        $this->GolubSendSms($order_id,'processing');
    }


    private function GolubSendSms($order_id,$status)
    {


        $order_details = new WC_Order($order_id);

        $message = $this->defaultOrderProcessingSms($order_id,'PROCESSING');
        $this->reformatPhoneNumbers($order_details->get_billing_phone());
        $ada_dialog = new AdaDialogSmsApi();
//        var_dump($ada_dialog->golubSendAdaMessageReuqest());

        die();

        //Send the SMS

    }
    private function defaultOrderProcessingSms($order_id,$order_status,$shop_name=null){
        $shop_name = get_bloginfo('name');
        return 'Your order '.'#'.$order_id.' is now.'.$order_status.'Thank you for shopping at '.$shop_name;
    }

    public static function reformatPhoneNumbers($value) {
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
