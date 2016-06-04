<?php

namespace Webdinhdalat\Backend\Controllers;
use Webdinhdalat\Commons\Authentication;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected final function createFolder($path)
    {
        try {
            if (!is_dir($path))
            {
                if(mkdir($path,'0777',true))
                    return 1;//run on server linux add params 0777, true
                else
                    return 0;//not create folder
            }
            return 2;//exist
        }
        catch (Exception $e)
        {
            return 3;
        }

    }
    public function initialize()
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
    }
}
