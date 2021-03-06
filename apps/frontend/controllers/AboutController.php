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
        $data = News::findFirstNewsOfCategory(self::page_about, self::language_id);

        if ($data == null) {
            return $this->response->redirect('/index');
        }
        $this->tag->prependTitle("$data->seo_title | ");
        self::setMetaDescription($data->seo_desc);
        return $this->view->data = array('data' => $data, 'menutitle' => 'Giới thiệu');
    }
}