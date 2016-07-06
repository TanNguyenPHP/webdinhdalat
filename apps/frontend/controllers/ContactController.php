<?php
namespace Webdinhdalat\Frontend\Controllers;
use Webdinhdalat\Modeldb\Models\Contact;

class ContactController extends ControllerBase
{

    public function indexAction()
    {

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

            $this->dispatcher->forward(array(
                'controller' => "contact",
                'action' => 'index'
            ));

            return;
        }

        return $this->response->redirect('/contact/index');
    }
}

