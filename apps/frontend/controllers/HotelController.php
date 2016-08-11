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
use Webdinhdalat\Modeldb\Models\Picture;
use Webdinhdalat\Modeldb\Models\Roombook;
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

    public function detailAction($id)
    {
        $this::AddCSSHotel();
        $this::AddJsHotel();
        $hotel = Roomtype::findFirstByslug($id);
        if (!$hotel) {
            $this->flash->error("Bài viết không tồn tại");
            return $this->response->redirect('/hotel/index');
        }
        $album = Picture::findPicOfAlbum($hotel->id_album);

        return $this->view->data = array('menutitle' => 'Khách Sạn',
            'hotel' => $hotel,
            'album' => $album);
    }
    public function createbookAction()
    {
        $room = new Roombook();
        $room->checkin = $this->request->getPost("dpd1");
        $room->checkout = $this->request->getPost("dpd2");
        $room->name = $this->request->getPost("bookname");
        $room->cellphone = $this->request->getPost("bookphone");
        $room->persons = $this->request->getPost("adult");
        $room->children = $this->request->getPost("children");
        $room->datecreate = date('YmdHis');
        $room->is_status = "0";
        $room->roomnumber = $this->request->getPost("rooms");

        if (!$room->save()) {
            foreach ($room->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                'controller' => "hotel",
                'action' => 'index'
            ));
        }
        return $this->response->redirect('/hotel/index');
    }
}