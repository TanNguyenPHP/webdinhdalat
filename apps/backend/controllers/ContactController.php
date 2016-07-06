<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\Contact;

class ContactController extends ControllerBase
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

        $contacts = Contact::findContactPaging($page, $limit, $name, $phone);

        $data = array(
            'data' => $contacts,
            'page' => $page,
            'limit' => $limit,
            'name' => $name,
            'phone' => $phone);
        return $this->view->data = $data;
    }

    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $contact= Contact::findFirstByid($id);
            if (!$contact) {
                $this->flash->error("Không có thông tin");
                return $this->response->redirect('backend/contact/index');
            }

            $this->view->data = $contact;
        }
    }

    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "contact",
                'action' => 'index'
            ));

            return;
        }
        $contact = Contact::findFirstByid($this->request->getPost("idcontact"));
        if (!$contact) {
            $this->flash->error("Không tồn tại");
            $this->dispatcher->forward(array(
                'controller' => "contact",
                'action' => 'index'
            ));
            return;
        }
        $contact->is_status = isset($_POST["is_status"]) ? '1' : '0';

        if (!$contact->save()) {
            foreach ($contact->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "contact",
                'action' => 'index'
            ));

            return;
        }

        $this->flash->success("Tạo mới thành công");
        return $this->response->redirect('/backend/contact/index');
    }
}

