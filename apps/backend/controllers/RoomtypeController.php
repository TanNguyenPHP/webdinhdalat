<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 06-08-2016
 * Time: 12:46 PM
 */
namespace Webdinhdalat\Backend\Controllers;

use Webdinhdalat\Modeldb\Models\Language;
use Webdinhdalat\Modeldb\Models\Roomtype;
use Webdinhdalat\Modeldb\Models\Language as Langs;
use Webdinhdalat\Modeldb\Models\Album;
use Webdinhdalat\Commons\ParamsConstant as params;
use Webdinhdalat\Commons\UtilsSEO;

class RoomtypeController extends ControllerBase
{
    public function indexAction()
    {
        $filter = "";
        $id_lang = "";

        if (isset($_GET['filter']))
            $filter = $_GET['filter'];
        if (isset($_GET['idlang']))
            $id_lang = $_GET['idlang'];

        return $this->view->data = array('rooms' => Roomtype::findAll($filter, $id_lang),
            'langs' => Langs::findAll(),
            'filter' => $filter,
            'idlang' => $id_lang);
    }

    public function newAction()
    {
        $this->assets
            ->addCss('/css/backend/select2.min.css');
        $this->assets
            ->addJs('/js/select2.full.min.js');
        return $this->view->data = array('albums' => Album::findAllOrderName(), 'langs' => Language::findAll());
    }

    public function editAction($id)
    {
        $room = Roomtype::findFirstByid($id);
        if (!$room) {
            $this->flash->error("Không tồn tại");
            return $this->response->redirect('/backend/roomtype/index');
        }

        $this->assets
            ->addCss('/css/backend/select2.min.css');
        $this->assets
            ->addJs('/js/select2.full.min.js');

        return $this->view->data = array('albums' => Album::findAllOrderName(),
            'langs' => Language::findAll(),
            'room' => $room);
    }
    public function saveAction()
    {
        $room = Roomtype::findFirstByid($this->request->getPost('id'));
        if (!$room) {
            $this->flash->error("Không tồn tại");
            return $this->response->redirect('/backend/roomtype/index');
        }
        $room->name = $this->request->getPost('name');
        $room->position = $this->request->getPost('position');
        $room->id_album = $this->request->getPost('album');
        $room->id_lang = $this->request->getPost('lang');
        $room->seo_desc = $this->request->getPost('seo_desc');
        $room->seo_title = $this->request->getPost('seo_title');
        $room->desc = $this->request->getPost('content');

        try {
            if (isset($_FILES['avatar_image'])) {
                if ($_FILES['avatar_image']['size'] != 0) {
                    $this::saveImg($_FILES['avatar_image']);
                    $room->avatar_image = Params::pathfolderavatarimage . $_FILES['avatar_image']['name'];
                }
            }

            if (!$room->save()) {
                foreach ($room->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward(array(
                    'controller' => "roomtype",
                    'action' => 'index'
                ));
            }
        } catch (Exception $e) {
            $this->flash->error(var_dump($e));
            $this->dispatcher->forward(array(
                'controller' => "roomtype",
                'action' => 'index'
            ));
        }

        return $this->response->redirect('/backend/roomtype/index');
    }
    public function createAction()
    {
        $room = new Roomtype();
        $room->name = $this->request->getPost('name');
        $room->position = $this->request->getPost('position');
        $room->is_show= '1';
        $room->id_album = $this->request->getPost('album');
        $room->id_lang = $this->request->getPost('lang');
        $room->seo_desc = $this->request->getPost('seo_desc');
        $room->seo_title = $this->request->getPost('seo_title');
        $room->slug = UtilsSEO::CreateSlug($room->name) . '-' . date('YmdHis');
        $room->desc = $this->request->getPost('content');
        try {
            $this::saveImg($_FILES['avatar_image']);
            $room->avatar_image = Params::pathfolderavatarimage . $_FILES['avatar_image']['name'];
            if (!$room->save()) {
                foreach ($room->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward(array(
                    'controller' => "news",
                    'action' => 'new'
                ));
            }
        } catch (Exception $e) {
            $this->flash->error(var_dump($e));
            $this->dispatcher->forward(array(
                'controller' => "roomtype",
                'action' => 'new'
            ));
        }

        return $this->response->redirect('/backend/roomtype/index');

    }
    public function changeshowAction()
    {
        $id = $this->request->getPost("id");
        $room = Roomtype::findFirstByid($id);
        if ($room->is_show == '0')
            $room->is_show = '1';
        else
            $room->is_show = '0';
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
        if ($room->is_show == '0')
            $data = 'fa fa-times';


        return $this::sendText($data);
    }
    private function saveImg($file)
    {
        $target = join(DIRECTORY_SEPARATOR, array(Params::folderimg, Params::folderimgavatar, basename($file['name'])));
        $this::saveFile($file['tmp_name'], $target);
    }
}