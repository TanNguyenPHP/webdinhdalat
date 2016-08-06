<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 19-07-2016
 * Time: 11:07 PM
 */
namespace Webdinhdalat\Frontend\Controllers;
use Phalcon\Mvc\View;
class HotelController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function detailAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}