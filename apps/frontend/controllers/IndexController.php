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
        $this->assets
            ->addCss('/css/frontend/main.css')
            ->addCss('/css/backend/jquery.datetimepicker.css');
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);//Render đến View tham khảo tại https://docs.phalconphp.com/en/latest/reference/views.html#control-rendering-levels
        $data = config::findFirst("id_lang = '1'");
        $menu = menu::findall('1');
        $datanews = News::findAllNewsOfCategory('1');
        return $this->view->data = array('data' => $data, 'menu' => $menu, 'news' => $datanews);
        //$json= json_encode(Maps::findAll('1'),JSON_UNESCAPED_UNICODE);
        //return $this->view->data = Maps::findAll('1');
        //return $this->view->data = json_encode(Maps::findAll('1'),JSON_UNESCAPED_UNICODE);
    }
}