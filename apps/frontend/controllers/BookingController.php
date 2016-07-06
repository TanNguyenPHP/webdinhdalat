<?php
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Booking;
use Webdinhdalat\Commons\UtilsDateTime;

class BookingController extends ControllerBase
{
    public function createAction()
    {
        $book = new Booking();

        $book->name = $this->request->getPost("namebook");
        $book->phone = $this->request->getPost("phonebook");
        $book->datecreate = UtilsDateTime::ConvertStringToDateTime($this->request->getPost("datebook"))->format('YmdHis');
        $book->content = $this->request->getPost("contentbook");
        $book->email = $this->request->getPost("emailbook");
        $book->is_status= '0';
        if (!$book->save()) {
            foreach ($book->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "index",
                'action' => 'index'
            ));

            return;
        }

        return $this->response->redirect('/index/index');
    }

}