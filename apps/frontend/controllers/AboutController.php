<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 6/24/2016
 * Time: 10:07 AM
 */
namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\News;

class AboutController extends ControllerBase
{
    public function indexAction()
    {
        $data = News::findFirstNewsOfCategory('4','1');

        if($data == null)
        {
            return $this->response->redirect('index/index');
        }
        $this->tag->prependTitle("Giới thiệu | ");
        return $this->view->data = $data;
    }
}