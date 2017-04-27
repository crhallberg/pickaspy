<?php

    namespace PickASpy;

    class Validator
    {
        protected $recaptchaKey;
        protected $libphonenumber;
        protected $remoteAddr;

        // TODO: Load configs in constructor
        public function __construct($key, $REMOTE_ADDR)
        {
            $this->recaptchaKey = $key;
            $this->remoteAddr = $REMOTE_ADDR;
            $this->libphonenumber = \libphonenumber\PhoneNumberUtil::getInstance();
        }

        /**
         * @return bool
         */
        public function validateForm()
        {
            // Check captcha
            $recaptcha = new \ReCaptcha\ReCaptcha($this->recaptchaKey);
            $resp = $recaptcha->verify($_POST['recaptcha'], $this->remoteAddr);
            return $resp->isSuccess();
        }

        /**
         * @return array Of valid numbers
         */
        public function validateNumbers($numbers)
        {
            $ip_location = json_decode(file_get_contents("https://ipinfo.io/{$this->remoteAddr}/json"));

            $validNumbers = [];
            for ($i = 0; $i < count($numbers); $i++) {
                $number_obj = $this->libphonenumber->parse(
                    $numbers[$i],
                    substr($numbers[$i], 0, 1) === '+'
                        ? null
                        : $ip_location->country
                );
                if ($this->libphonenumber->isValidNumber($number_obj)) {
                    $validNumbers[] = $number_obj;
                }
            }
            return $validNumbers;
        }

        /**
         * Expose libphonenumber format
         */
        public function formatNumber($number_obj, $format)
        {
            return $this->libphonenumber->format($number_obj, $format);
        }
    }
