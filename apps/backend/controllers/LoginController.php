<?php

namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\View;
use Webdinhdalat\Modeldb\Models\Users;
use Webdinhdalat\Commons\SecuritySystem;

class LoginController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateAfter('sharelogin');

    }

    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);//Render đến View tham khảo tại https://docs.phalconphp.com/en/latest/reference/views.html#control-rendering-levels
    }

    public function loginAction()
    {
        if (!$this->request->isPost()) {
            if (!$this->security->checkToken()) {
                return $this->dispatcher->forward(array(
                    'controller' => "login",
                    'action' => 'index'
                ));
            }
            //return;
        }
        //$response = new \Phalcon\Http\Response();

        $username = $this->request->getPost("UserName");
        $password = SecuritySystem::HashPassword($this->request->getPost("Password"));

        $_checklogin = $this->checklogin($username, $password);

        if ($_checklogin == 0)//Success
        {
            return $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'index'
            ));
        }
        $user = Users::findFirst("username = '$username'");
        if ($_checklogin == 3 || $_checklogin = 4 ||$_checklogin = 5) {
            $this->flashSession->error("$password");//$this->flash->error("Wrong username or password");
            return $this->response->redirect('quanly');
        }
        if ($_checklogin == 2) {
            $this->flashSession->error("Account not active");//$this->flash->error("Account not active");
            return $this->response->redirect('quanly');
        }

        return $this->response->redirect('quanly');
    }

    ////////////////////function helper////////////////////////////////////////////////////////////////////
    private function checklogin($Username, $Password)
    {
        $user = Users::findFirst("username = '$Username'");
        if ($user != null) {
            if ($Password == $user->password) {
                if ($user->is_active == '1' & $user->is_del == '0') {
                    registerSessionUser($user);
                    return 0;
                }// Success
                else if ($user->is_del == '1')
                    return 1;// account del
                else if ($user->is_active == '0')
                    return 2;// account not active
            } else {
                return 3;//Wrong password
            }
        } else {
            return 4;// Wrong username
        }
        return 5;
    }

    private function registerSessionUser($user)
    {
        $this->session->set('sessionUser', $user->id);
    }

}

