<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 19-07-2016
 * Time: 11:07 PM
 */
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Sliderpichotel;
use Webdinhdalat\Modeldb\Models\Roomtype;
use Phalcon\Mvc\View;

class HotelController extends ControllerBase
{
    public function indexAction()
    {
        $this::AddCSSHotel();
        $this::AddJsHotel();
        $hotels = Roomtype::findAll('', self::language_id, self::is_show);
        return $this->view->data = array('menutitle' => 'Khách Sạn',
            'sliderpic' => Sliderpichotel::findAllShow(),
            'hotels' => $hotels);
    }

    public function detailAction()
    {
        $this::AddCSSHotel();
        $this::AddJsHotel();
        return $this->view->data = array('menutitle' => 'Khách Sạn');
    }
}