<?php
/**
 * Created by PhpStorm.
 * User: tannb
 * Date: 5/24/2016
 * Time: 15:26
 */

namespace Webdinhdalat\commons;

use Phalcon\Security;

class SecuritySystem
{
    public static function HashPassword($pass = '')
    {
        $key = '2016';
        $security = new Security();
        return $security->hash($pass . $key);
    }
}
