<?php

    if (! function_exists('validateDate')) {
        /**
         * baseUrl
         *
         * @return string
         */
        function baseUrl()
        {
            return $_ENV['BASEURL'];
        }
    }
    
    if (! function_exists('validateDate')) {
        /**
         * validateDate
         *
         * @param mixed $date 
         * @param string $format 
         * @return bool
         */
        function validateDate($date, $format = 'Y-m-d H:i:s')
        {
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) == $date;
        }
    }