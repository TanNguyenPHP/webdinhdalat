<?php

namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\View;
use Webdinhdalat\Modeldb\Models\Webconfig as config;
use Webdinhdalat\Modeldb\Models\Menu as menu;
use Webdinhdalat\Modeldb\Models\News;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        //$this->assets
        //    ->addCss('/css/frontend/main.css')
        //    ->addCss('/css/backend/jquery.datetimepicker.css');
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);//Render đến View tham khảo tại https://docs.phalconphp.com/en/latest/reference/views.html#control-rendering-levels
        $id_lang= self::language_id;
        $data = config::findFirst("id_lang = '$id_lang'");
        $menu = menu::findall('1','1');
        $datanews = News::findAllNewsOfCategory('1');
        $newsservices = News::findAllNewsOfCategory('8');
        return $this->view->data = array('data' => $data, 'menu' => $menu, 'news' => $datanews,'services'=>$newsservices);

    }
}