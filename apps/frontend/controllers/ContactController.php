<?php
namespace Webdinhdalat\Frontend\Controllers;
use Webdinhdalat\Modeldb\Models\Contact;
use Webdinhdalat\Modeldb\Models\Menu;

class ContactController extends ControllerBase
{

    public function indexAction()
    {
        $data = Menu::findFirst("id = '2'");

        $this->tag->prependTitle($data->title . " | ");
        self::setMetaDescription($data->meta_description);
        return $this->view->data = array('menutitle' => 'Bản đồ');
    }
    public function createAction()
    {

        $contact = new Contact();
        $contact->email = $this->request->getPost("emailcontact");
        $contact->name = $this->request->getPost("namecontact");
        $contact->subject = $this->request->getPost("subjectcontact");
        $contact->content = $this->request->getPost("messagecontact");
        $contact->is_status = "0";
        $contact->date = date('YmdHis');
        if (!$contact->save()) {
            foreach ($contact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                'controller' => "contact",
                'action' => 'index'
            ));
        }
        return $this->response->redirect('/contact/index');
    }
}

