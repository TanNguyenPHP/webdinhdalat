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
        $this::AddCSSHotel();
        $this::AddJsHotel();
        //$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        return $this->view->data = array('menutitle'=>'Khách Sạn');
    }

    public function detailAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}