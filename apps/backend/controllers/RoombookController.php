<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 07-08-2016
 * Time: 3:58 PM
 */
namespace Webdinhdalat\Backend\Controllers;

use Webdinhdalat\Modeldb\Models\Roombook;

class RoombookController extends ControllerBase
{
    public function indexAction()
    {
        $filter = "";
        $page = 1;
        $limit = 50;
        if (isset($_GET['filter']))
            $filter = $_GET['filter'];
        if (isset($_GET['page']))
            $page = $_GET['page'];

        $data = Roombook::findRoomBookPaging($page, $limit, $filter);

        $this->view->data = array('filter' => $filter, 'page' => $page, 'data' => $data);
    }

    public function changestatusAction()
    {
        $id = $this->request->getPost("id");
        $room = Roombook::findFirstByid($id);
        $room->is_status = '1';
        try {

            if (!$room->save()) {
                foreach ($room->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "fa fa-check-circle";

        return $this::sendText($data);
    }
}