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
    private static function HashPasswords($pass, $username)
    {
        $security = new Security();
        $security->setDefaultHash(3);//MD5
        $key = self::GenKey($username);
        return $security->hash($pass , $key) . $key;
    }

    public static function HashPassword($pass, $username)
    {
        $security = new Security();
        $security->setDefaultHash(8);//Sha512
        return $security->hash($pass);
    }

    public static function CheckHashPassword($pass, $passcompare)
    {
        $security = new Security();
        $security->setDefaultHash(8);//Sha512
        if ($security->checkHash($pass, $passcompare))
            return true;
        else
            return false;
    }

    private static function GenPassword($username, $password)
    {
        $key = self::GenKey($username);// GenKey($username);
        $crypt = new Crypt();
        $crypt->setPadding(4);//PADDING_ISO_IEC_7816_4
        $encrypted = $crypt->encryptBase64($password, '1');
        return $encrypted;
    }

    private static function GenKey($username)
    {
        return sha1($username);
    }

    private static function CheckPassword($password, $userpass)
    {
        $security = new Security();
        $security->setDefaultHash(8);
        if ($security->checkHash($password, $userpass))
            return true;
        else
            return false;
    }
}
