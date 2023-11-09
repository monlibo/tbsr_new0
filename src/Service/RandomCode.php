<?php
namespace App\Service;

class RandomCode {

    public function __construct()
    {
      
    }

    function generateRandomCode($length = 10) {
        $characters = 'ABCz01234D.EFGHIz01$456234JKLMNOPQz01234RSTUVWXYZabcdefghijklmnoz!01234pqrstu4pv#wxyz0123456789';
        $code = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, $max)];
        }
        return $code;
    }
    
}