<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 06-07-2016
 * Time: 11:00 AM
 */
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Newsletter;

class NewsletterController extends ControllerBase
{
    public function CreateAction()
    {
        $letter = new Newsletter();
        $letter->email = $this->request->getPost('emailletter');
        $letter->is_status = '0';
        if (!$letter->save()) {
            foreach ($letter->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "index",
                'action' => 'index'
            ));

            return;
        }

        return $this->response->redirect('/index');
    }
}