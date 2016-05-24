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
            $this->dispatcher->forward(array(
                'controller' => "login",
                'action' => 'index'
            ));

            return;
        }

        $username = $this->request->getPost("username");
        $password = SecuritySystem::HashPassword($this->request->getPost("password"));

        $user = Users::findFirstByLogin($username);

        if($user)
        {
            if ($this->security->checkHash($password, $user->password))
            {
                $this->session->set('userlogin',$user->id);
                $this->dispatcher->forward(array(
                    'controller' => "users",
                    'action' => 'index'
                ));
            }
            else
            {
                $this->flash->error("Wrong password");
                $this->dispatcher->forward(array(
                    'controller' => "login",
                    'action' => 'index'
                ));
            }
        }
        else
        {
            $this->flash->error("Wrong Username");
            $this->dispatcher->forward(array(
                'controller' => "login",
                'action' => 'index'
            ));
        }

    }

}

