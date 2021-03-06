<?php

namespace Webdinhdalat\Backend\Controllers;

use Webdinhdalat\Commons\Authentication;
use Phalcon\Mvc\Controller;
use Phalcon\Di;
class ControllerBase extends Controller
{
    protected final function UrlBase()
    {
        return $_SERVER['SERVER_NAME'];
    }

    protected final function createFolder($path)
    {
        try {
            if (!is_dir($path)) {
                if (mkdir($path))
                    return 1;//run on server linux add params 0777, true
                else
                    return 0;//not create folder
            }
            return 2;//exist
        } catch (Exception $e) {
            return 3;
        }

    }

    protected final function saveFile($path, $destination)
    {
        try {
            move_uploaded_file($path, $destination);
            return true;
        } catch (Exception $e) {

        }
    }

    public function initialize()
    {
        // Add some local CSS resources
        $this->assets
            ->addCss('/css/backend/bootstrap.min.css')
            ->addCss('/css/backend/font-awesome.min.css')
            ->addCss('/css/backend/modalStyles.css')
            ->addCss('/css/backend/AdminLTE.min.css')
            ->addCss('/css/backend/skin-blue.min.css')
            ->addCss('/css/backend/jquery.datetimepicker.css')
            ->addCss('/css/backend/alertify.css')
            ->addCss('/css/backend/semantic.min.css')
            ->addCss('/css/backend/fine-uploader-new.css');


        // And some local JavaScript resources
        $this->assets
            ->addJs('/js/jquery-1.12.4.min.js')
            ->addJs('/js/jquery.validate.min.js')
            ->addJs('/js/jquery.datetimepicker.full.min.js')
            ->addJs('/js/fine-uploader.min.js')
            ->addJs('/js/alertify.min.js')
            ->addJs('/ckeditor/tinymce.min.js');

        if (!Authentication::CheckAuth())
            return $this->response->redirect('/quanly');
        $name = Di::getDefault()->getSession()->get('sessionUser');
        return $this->view->userinfo = $name['name'];
    }
    protected function sendJson($data) {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($data));
        return $this->response;
    }
    protected function sendText($data) {
        $this->view->disable();
        $this->response->setContentType('text/plain', 'UTF-8');
        $this->response->setContent($data);
        return $this->response;
    }
}
