<?php

namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Webdinhdalat\Commons\ParamsSEO;
use Webdinhdalat\Modeldb\Models\Menu as menu;
use Webdinhdalat\Modeldb\Models\Webconfig as config;
use Webdinhdalat\commons\ParamsCookie;

class ControllerBase extends Controller
{
    public function initialize()
    {
        // Add some local CSS resources
        $this->assets
            ->addCss('/css/frontend/Vendor/awesome-font/font-awesome.css')
            ->addCss('/css/frontend/iconmoon.css')
            ->addCss('/css/frontend/hotel/bootstrap.min.css')
            ->addCss('/css/frontend/main.css')
            ->addCss('/css/frontend/responsive.css')
            ->addCss('/css/backend/jquery.datetimepicker.css');
        $this->assets
            ->addJs('/js/jquery-1.12.4.min.js')
            ->addJs('/js/main.js')
            ->addJs('/js/jquery.validate.min.js')
            ->addJs('/js/jquery.datetimepicker.full.min.js');
        $data = config::findFirst("id_lang = '1'");//Language
        $menu = menu::findall('1', '1');//Language
        $this->tag->setTitle($data->title);
        self::setMetaDescription($data->meta);
        return $this->view->datamain = array('data' => $data, 'menu' => $menu);
    }

    protected function setMetaDescription($content)
    {
        ParamsSEO::$meta_description = "$content";
    }

    protected function getParamCookie()
    {
        return ParamsCookie::$menutitle;
    }

    protected function sendJson($data)
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($data));
        return $this->response;
    }

    protected function sendText($data)
    {
        $this->view->disable();
        $this->response->setContentType('text/plain', 'UTF-8');
        $this->response->setContent($data);
        return $this->response;
    }

    protected function SetCookie($name = null, $value = null)
    {
        if (isset($_COOKIE[$name])) {
            $_COOKIE[$name] = $value;
        } else {
            setcookie($name, $value, time() + (60 * 60 * 24));
        }
    }

}
