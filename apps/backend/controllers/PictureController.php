<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\Picture;
use Webdinhdalat\Modeldb\Models\Album;
use Webdinhdalat\Commons\ParamsConstant as params;
use Webdinhdalat\Commons\RemoveUnicode;

class PictureController extends ControllerBase
{

    public function newAction()
    {
        $this->view->data= Album::find();
    }
    public function createAction()
    {
        $pic = new Picture();
        $file = $_FILES['qqfile']['name'];


    }
}

