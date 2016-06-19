<?php

namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\View;

class TestController extends ControllerBase
{

    public function initialize()
    {

    }

    public function indexAction()
    {
           $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);//Render đến View tham khảo tại https://docs.phalconphp.com/en/latest/reference/views.html#control-rendering-levels
    }
}