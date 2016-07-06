<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\Booking;

class BookingController extends ControllerBase
{

    public function indexAction()
    {
        $name = "";
        $phone = "";
        $page = 1;
        $limit = 10;

        if (isset($_GET['name']))
            $name = $_GET['name'];
        if (isset($_GET['phone']))
            $phone = $_GET['phone'];
        if (isset($_GET['page']))
            $page = $_GET['page'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        $books = Booking::findBookPaging($page, $limit, $name, $phone);

        $data = array(
            'data' => $books,
            'page' => $page,
            'limit' => $limit,
            'name' => $name,
            'phone' => $phone);
        return $this->view->data = $data;
    }

    public function changestatusAction()
    {
        $id = $this->request->getPost("id");
        $book = Booking::findFirstByid($id);
        $book->is_status = '1';
        if (!$book) {
            $this->flash->error("Thông tin ko tồn tại");

            $this->dispatcher->forward(array(
                'controller' => "booking",
                'action' => 'index'
            ));

            return;
        }
        try {

            if (!$book->save()) {
                foreach ($book->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('fa fa-times');
            }
        } catch (Exception $e) {
            return $this::sendText('fa fa-times');
        }

        return $this::sendText('fa fa-check-circle');
    }
}

