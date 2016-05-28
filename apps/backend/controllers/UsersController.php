<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\Users;
use Webdinhdalat\Commons\SecuritySystem;
use Webdinhdalat\Commons\Authentication;

class UsersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
        //$this->persistent->parameters = null;
        $filter = '';
        $page = 1;
        $limit = 20;
        if (isset($_GET['filter']))
            $filter = $_GET['filter'];
        if (isset($_GET['page']))
            $page = $_GET['page'];
        $data = Users::findUsersPaging($filter, $filter, $page, $limit);
        $this->view->dataUsers = $data;

        //https://docs.phalconphp.com/en/latest/reference/models.html

    }

    /**
     * Searches for users
     */
    public function searchAction()
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Webdinhdalat\Modeldb\Models\Users', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $users = Users::find($parameters);
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");

            $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $users,
            'limit' => 10,
            'page' => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
    }

    /**
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
        if (!$this->request->isPost()) {

            $user = Users::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");
                return $this->response->redirect('backend/users/index');
            }

            $this->view->user = $user;
            /*
            $this->view->id = $user->id;
            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("username", $user->username);
            $this->tag->setDefault("password", $user->password);
            $this->tag->setDefault("datecreate", $user->datecreate);
            $this->tag->setDefault("is_active", $user->is_active);
            $this->tag->setDefault("is_del", $user->is_del);
            $this->tag->setDefault("room", $user->room);
            $this->tag->setDefault("desc", $user->desc);
            */
        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'index'
            ));

            return;
        }

        $user = new Users;
        //$user->id = $this->request->getPost("id");
        $user->username = $this->request->getPost("username");
        $user->password = SecuritySystem::HashPassword($this->request->getPost("password"), $user->username);
        $user->datecreate = date('YdmHis');
        $user->is_active = '1';
        $user->is_del = '0';

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("user was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "users",
            'action' => 'index'
        ));
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'index'
            ));

            return;
        }

        $id = $this->request->getPost("id");
        $user = Users::findFirstByid($id);

        if (!$user) {
            $this->flash->error("user does not exist " . $id);

            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'index'
            ));

            return;
        }

        $user->datecreate = $this->request->getPost("name");
        $user->is_active = $this->request->getPost("is_active");

        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'edit',
                'params' => array($user->id)
            ));

            return;
        }

        $this->flash->success("user was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "users",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('quanly');
        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'index'
            ));

            return;
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("user was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "users",
            'action' => "index"
        ));
    }

}
