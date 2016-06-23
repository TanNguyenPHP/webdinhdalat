<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\Category as Cat;

class CategoryController extends ControllerBase
{


    public function indexAction()
    {
        $cats = Cat::findAll();
        $listcat = $cats;
        $catlist = array();
        for ($j = 0; $j < count($cats); $j++) {
            $cat = array(
                "id" => $cats[$j]->id,
                "name" => $cats[$j]->name,
                "desc" => $cats[$j]->desc,
                "pid" => 'Danh mục chính',
                "is_status" => $cats[$j]->is_status
            );
            for ($i = 0; $i < count($listcat); $i++) {
                if ($listcat[$i]->id == $cats[$j]->pid) {
                    $cat['pid'] = $listcat[$i]->name;
                }

            }
            array_push($catlist, $cat);
        }
        return $this->view->data = $catlist;
    }

    public function newAction()
    {
        $this->view->data = Cat::findAll();
    }

    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "category",
                'action' => 'create'
            ));
            return;
        }
        $cats = new Cat();

        $cats->name = $this->request->getPost("name");
        $cats->desc = $this->request->getPost("desc");
        $cats->pid = $this->request->getPost("pid");
        $cats->is_status = '1';
        if (!$cats->save()) {
            foreach ($cats->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "category",
                'action' => 'new'
            ));

            return;
        }
        $this->flash->success("Tạo mới thành công");

        return $this->response->redirect('/backend/category/index');
    }

    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $cat = Cat::findFirstByid($id);
            if (!$cat) {
                $this->flash->error("Không tìm thấy");
                return $this->response->redirect('/backend/users/index');
            }
            $cats = array(
                "cat" => $cat,
                "cats" => Cat::find("id != $cat->id and is_status != '3' ")
            );

            $this->view->data = $cats;
        }
    }

    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "category",
                'action' => 'index'
            ));

            return;
        }

        $id = $this->request->getPost("id");
        $cat = Lang::findFirstByid($id);

        if (!$cat) {
            $this->flash->error("Không tìm thấy danh mục");

            $this->dispatcher->forward(array(
                'controller' => "category",
                'action' => 'index'
            ));

            return;
        }

        $cat->name = $this->request->getPost("name");
        $cat->is_status = isset($_POST["is_status"]) ? '1' : '0';
        $cat->pid = $this->request->getPost("pid");
        $cat->desc = $this->request->getPost("desc");
        if (!$cat->save()) {

            foreach ($cat->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "category",
                'action' => 'edit',
                'params' => array($cat->id)
            ));

            return;
        }

        $this->flash->success("Đã lưu");
        return $this->response->redirect('/backend/category/index');
    }

}

