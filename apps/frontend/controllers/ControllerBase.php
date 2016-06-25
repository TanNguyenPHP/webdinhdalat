<?php

namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        // Add some local CSS resources
        $this->assets
            ->addCss('/css/frontend/main.css')
            ->addCss('/css/backend/jquery.datetimepicker.css');
        $this->assets
            ->addJs('/js/jquery-1.12.4.min.js')
            ->addJs('/js/jquery.validate.min.js')
            ->addJs('/js/jquery.datetimepicker.full.min.js')
            ->addJs('/js/fine-uploader.min.js')
            ->addJs('/js/alertify.min.js')
            ->addJs('/ckeditor/tinymce.min.js');
        $this->tag->setTitle("Dinh Đà Lạt");

    }

    protected function sendJson($data)
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($data));
        return $this->response;
    }

    protected function sendText($data)
    {
        $this->view->disable();
        $this->response->setContentType('text/plain', 'UTF-8');
        $this->response->setContent($data);
        return $this->response;
    }
}
