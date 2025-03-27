<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations {

    public static function dcryptId($value) {
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return null;
        }
        return $value;
    }
}