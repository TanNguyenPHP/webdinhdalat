<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\MapsInfo as Maps;
use Webdinhdalat\Modeldb\Models\Language as Lang;
use Webdinhdalat\Commons\ParamsConstant as Params;

class MapsinfoController extends ControllerBase
{

    public function indexAction()
    {

        $lang = '';
        if (isset($_GET['lang']))
            $lang = $_GET['lang'];
        $data = array(
            "mapsinfo" => Maps::findAll($lang),
            "langs" => Lang::findAll(),
            "lang" => $lang
        );
        return $this->view->data = $data;
    }

    public function newAction()
    {
        $langs = Lang::findAll();

        return $this->view->data = $langs;
    }

    public function editAction($id)
    {

        $info = Maps::findFirstByid($id);
        if (!$info) {
            $this->flash->error("Không có thông tin");
            return $this->response->redirect('backend/mapsinfo/index');
        }
        $data = array(
            "mapsinfo" => $info,
            "langs" => Lang::findAll()
        );
        return $this->view->data = $data;
    }

    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                'controller' => "mapsinfo",
                'action' => 'index'
            ));
        }
        $info = Maps::findFirstByid($this->request->getPost('id'));
        if (!$info) {
            $this->flash->error("Không có thông tin");
            return $this->response->redirect('backend/mapsinfo/index');
        }
        $info->id_lang = $this->request->getPost('lang');
        $info->content = $this->request->getPost('content');
        $info->position = $this->request->getPost('position');
        $info->title = $this->request->getPost('title');
        $info->is_status = isset($_POST["is_status"]) ? '1' : '0';

        try {
            if (!empty($_FILES['image'])) {
                if($_FILES['image']['size'] != 0)
                {
                    $this::saveImg($_FILES['image']);
                    $info->image = Params::pathfoldermapimage . $_FILES['image']['name'];
                }
            }

            if (!$info->save()) {
                foreach ($info->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward(array(
                    'controller' => "mapsinfo",
                    'action' => 'new'
                ));
            }
        } catch (Exception $e) {
            $this->flash->error(var_dump($e));
            $this->dispatcher->forward(array(
                'controller' => "mapsinfo",
                'action' => 'new'
            ));
        }

        return $this->response->redirect('backend/mapsinfo/index');
    }

    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                'controller' => "mapsinfo",
                'action' => 'index'
            ));
        }

        $info = new Maps();
        $info->id_lang = $this->request->getPost('lang');
        $info->content = $this->request->getPost('content');
        $info->position = $this->request->getPost('position');
        $info->title = $this->request->getPost('title');
        $info->is_del = '0';
        $info->is_status = '1';

        try {
            if (isset($_FILES['image'])) {
                $this::saveImg($_FILES['image']);
                $info->image = Params::pathfoldermapimage . $_FILES['image']['name'];
            }

            if (!$info->save()) {
                foreach ($info->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward(array(
                    'controller' => "mapsinfo",
                    'action' => 'new'
                ));
            }
        } catch (Exception $e) {
            $this->flash->error(var_dump($e));
            $this->dispatcher->forward(array(
                'controller' => "mapsinfo",
                'action' => 'new'
            ));
        }

        return $this->response->redirect('index');

    }
    private function saveImg($file)
    {
        $this::createFolder(Params::pathfoldermapimage);
        $uploadfile = Params::pathfoldermapimage . basename($file['name']);
        $this::saveFile($file['tmp_name'], $uploadfile);
    }
}

