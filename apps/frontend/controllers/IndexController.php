<?php

namespace Webdinhdalat\Frontend\Controllers;
use Phalcon\Mvc\View;

class IndexController extends ControllerBase
{
    public function initialize()
    {

    }
    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);//Render đến View tham khảo tại https://docs.phalconphp.com/en/latest/reference/views.html#control-rendering-levels
        //$json= json_encode(Maps::findAll('1'),JSON_UNESCAPED_UNICODE);
        //return $this->view->data = Maps::findAll('1');
        //return $this->view->data = json_encode(Maps::findAll('1'),JSON_UNESCAPED_UNICODE);
    }
}

