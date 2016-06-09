<?php

namespace Webdinhdalat\Frontend\Controllers;
use Webdinhdalat\Modeldb\Models\MapsInfo as Maps;
use Webdinhdalat\Commons\ParamsConstant as Params;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $json= json_encode(Maps::findAll('1'),JSON_UNESCAPED_UNICODE);
        return $this->view->data = Maps::findAll('1');
        //return $this->view->data = json_encode(Maps::findAll('1'),JSON_UNESCAPED_UNICODE);
    }

}

