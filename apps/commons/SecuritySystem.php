<?php
/**
 * Created by PhpStorm.
 * User: tannb
 * Date: 5/24/2016
 * Time: 15:26
 */

namespace Webdinhdalat\commons;

use Phalcon\Security;
use Phalcon\CryptInterface;
use Phalcon\Crypt\Exception;
use Phalcon\Crypt;

class SecuritySystem
{
//    public static function HashPassword($pass = '')
//    {
//        $key = '2016';
//        $security = new Security();
//        return $security->sha($pass);
//    }

    public static function GenPassword($username, $password)
    {
        $key = self::GenKey($username);// GenKey($username);
        $crypt = new Crypt();
        return $crypt->encrypt($password, $key);
    }

    private static function GenKey($username)
    {
        return md5($username);
    }
}
