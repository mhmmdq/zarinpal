<?php

    /**
     * @author      Mhmmdq <mhmmdq@mhmmdq.ir>
     * @copyright   Copyright (c), 2021 Mhmmdq
     * @license     MIT public license
     */
    namespace Mhmmdq\Zarinpal;

    class Zarinpal {
        /**
         * Inside this variable is the merchant received from ZarinPal
         *
         * @var string  
         */
        private $merchant;

        /**
         * The payment rate for ZarinPal payment portal can be found here
         *
         * @var int 
         */
        protected $amount;
        
        /**
         * After being transferred to the payment gateway, where it will be directed will be kept here
         *
         * @var string 
         */
        protected $callback_url;

        /**
         * Payment details are kept here
         *
         * @var string 
         */
        protected $description;

        /**
         * All the data needed to transfer is here
         *
         * @var array 
         */
        protected $metadata;

        /**
         * This variable is used if there is a problem in the payment process
         *
         * @var bool 
         */ 
        private $error;

        /**
         * Interpretation of all return codes from ZarrinPal with Persian translation is available in this presentation
         * Source : https://docs.zarinpal.com/paymentGateway/error.html
         *
         * @var array 
         */ 
        protected $zarinResultCode = [
            '-9' => ['Validation error' , 'خطای اعتبار سنجی'] , 
            '-10' => ['Terminal is not valid, please check merchant_id or ip address.' , 'ای پی و يا مرچنت كد پذيرنده صحيح نيست'] ,
            '-11' => ['Terminal is not active, please contact our support team.' , 'مرچنت کد فعال نیست لطفا با تیم پشتیبانی ما تماس بگیرید'] ,
            '-12' => ['To many attempts, please try again later.' , 'تلاش بیش از حد در یک بازه زمانی کوتاه.'] , 
            '-15' => ['Terminal user is suspend : (please contact our support team).' , 'ترمینال شما به حالت تعلیق در آمده با تیم پشتیبانی تماس بگیرید'] , 
            '-16' => ['Terminal user level is not valid : ( please contact our support team).' , 'سطح تاييد پذيرنده پايين تر از سطح نقره اي است.'],
            '100' => ['Success' , 'عملیات موفق'] ,
            '-30' => ['Terminal do not allow to accept floating wages.' , 'اجازه دسترسی به تسویه اشتراکی شناور ندارید'] ,
            '-31' => ['Terminal do not allow to accept wages, please add default bank account in panel.' , 'حساب بانکی تسویه را به پنل اضافه کنید مقادیر وارد شده واسه تسهیم درست نیست'],
            '-32' => ['Wages is not valid, Total wages (floating) has been overload max amount.' , 'دستمزد معتبر نیست ، مجموع دستمزد (شناور) حداکثر مقدار اضافه بار است.'],
            '-33' => ['Wages floating is not valid.' , 'درصد های وارد شده درست نیست'],
            '-34' => ['Wages is not valid, Total wages(fixed) has been overload max amount.' , 'مبلغ از کل تراکنش بیشتر است'] , 
            '-35' => ['Wages is not valid, Total wages(floating) has been reached the limit in max parts.' , 'تعداد افراد دریافت کننده تسهیم بیش از حد مجاز است'] ,
            '-40' => ['Invalid extra params, expire_in is not valid.' , 'پارامترهای اضافی نامعتبر ، expire_in معتبر نیست.'] , 
            '-50' => ['Session is not valid, amounts values is not the same.' , 'مبلغ پرداخت شده با مقدار مبلغ در وریفای متفاوت است'] , 
            '-51' => ['Session is not valid, session is not active paid try.' , 'پرداخت ناموفق'] , 
            '-52' => ['Oops!!, please contact our support team' , 'خطای غیر منتظره با پشتیبانی تماس بگیرید'] , 
            '-53' => ['Session is not this merchant_id session' , 'اتوریتی برای این مرچنت کد نیست'] , 
            '-54' => ['Invalid authority.' , 'اتوریتی نامعتبر است'] , 
            '101' => ['Verified' , 'تراکنش وریفای شده']
        ];

        /**
         * Receive the information needed to build the gateway and confirm payment
         *
         * @param string $merchant
         * @param int $amount
         * @param string $callback_url
         * @param string $description
         * @param array $metadata
         */
        public function __construct(string $merchant ,$amount = null , string $callback_url = '' , string $description = '' , array $metadata = [])
        {

            $this->merchant = $merchant;


            $this->amount = $amount;
            $this->callback_url = $callback_url;
            $this->description = $description;
            $this->metadata = $metadata;

        }
        /**
         * Receive payment by the portal
         *
         * @param int $amount
         * @return void
         */
        public function amount($amount) {

            $this->amount = $amount;

        }
        /**
         * Receive a return address after the payment operation
         *
         * @param string $callback_url
         * @return void
         */
        public function callback_url(string $callback_url) {

            $this->callback_url = $callback_url;

        }
        /**
         * Record payment operation descriptions
         *
         * @param string $description
         * @return void
         */
        public function description(string $description) {

            $this->description = $description;

        }
        /**
         * Provide any information needed to switch between the payment page and payment confirmation
         *
         * @param array $metadata
         * @return void
         */
        public function metadata(array $metadata) {

            $this->metadata = $metadata;

        }
        /**
         * Check for all required values
         * 
         */
        private function checkـvalues() {

            return !empty($this->amount) && !is_null($this->amount) &&
                    !empty($this->callback_url) && !is_null($this->callback_url) &&
                    !empty($this->description) && !is_null($this->description) &&
                    !empty($this->metadata);

        }
        /**
         * Check for problems in the payment process
         *
         * @param array $response
         * @return boolean
         */
        private function has_error($response) {

           if(!empty($response['errors'])) {
                $this->error = true;
                $code = $response['errors']['code'];
                return ['error' => ['code' => $code,
                                    'message' => ['en' => $this->zarinResultCode[$code][0] , 'fa' => $this->zarinResultCode[$code][1]]
                                    ]
                        ];

           }else {

               return true;

           }

        }

        /**
         * Send data to ZarinPal
         *
         * @param string $url
         * @param string $JsonData
         * @return void
         */
        protected function send_request($url  , $JsonData) {

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $JsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($JsonData)
            ));

            $result = curl_exec($ch);
            $err = curl_error($ch);
            
            if($err) {
                


            } else {
                return json_decode($result, true, JSON_PRETTY_PRINT);
            }

            curl_close($ch);

        }

        /**
         * Build ZarinPal payment link
         *
         * @return void
         */
        protected function makepaymentPortal() {

            if(!$this->checkـvalues()) {
                return false;
            }

            $JsonData = json_encode([
                "merchant_id" => $this->merchant,
                "amount" => $this->amount,
                "callback_url" => $this->callback_url,
                "description" => $this->description,
                "metadata" => $this->metadata

            ]);

            
            $result = $this->send_request('https://api.zarinpal.com/pg/v4/payment/request.json' , $JsonData);


            $has_error = $this->has_error($result);

            if($has_error === true) {
                
                 if($result['data']['code'] == 100) {

                     return 'https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"];

                 }

             }else {

                 return $has_error;

             }

            

        }

        /**
         * Perform transfer or display ZarinPal payment link
         *
         * @param boolean $header
         * @return void
         */
        public function PayMentPortal($header = true) {

            $paymentLocation = $this->makepaymentPortal();

               if($this->error === true || $header !== true) {

                    return $paymentLocation;

               }else {
                        header("Location: " . $paymentLocation);
                        exit();
               }

        }

        /**
         * Payment transaction confirmation process
         *
         * @return void
         */
        public function PayMentVerify() {

            $Authority = $_GET['Authority'];
            $JsonData = json_encode([
                "merchant_id" => $this->merchant,
                "authority" => $Authority, 
                "amount" => $this->amount
            ]);

            $result = $this->send_request('https://api.zarinpal.com/pg/v4/payment/verify.json' , $JsonData);

            $has_error = $this->has_error($result);

            if($has_error === true) {
                
                 if($result['data']['code'] == 100) {

                     return ['status' => 'success' , 'ref_id' => $result['data']['ref_id'], 'data' => $result['data']];

                 }

             }else {

                 return $has_error;

             }


        }









    }