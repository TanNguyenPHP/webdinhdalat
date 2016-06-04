<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\News;
use Webdinhdalat\Modeldb\Models\Category;
use Webdinhdalat\Modeldb\Models\Language as Lang;
use Webdinhdalat\Commons\Authentication;

class NewsController extends ControllerBase
{
    public function indexAction()
    {

        $dateTo = "";
        $dateFrom = "";
        $filter = "";
        $cat = "";
        $limit = 20;
        $page = 1;

        if (isset($_GET['dateTo']))
            $dateTo = $_GET['dateTo'];
        if (isset($_GET['dateFrom']))
            $dateFrom = $_GET['dateFrom'];
        if (isset($_GET['filter']))
            $filter = $_GET['filter'];
        if (isset($_GET['cat']))
            $cat = (int)$_GET['cat'];
        if (isset($_GET['limit']))
            $limit = (int)$_GET['limit'];
        if (isset($_GET['page']))
            $page = (int)$_GET['page'];

        $listnews = News::findNewsPaging($page, $limit, $filter, $dateTo, $dateFrom, $cat);
        //$cats = Category::findAll();

        $data = array(
            "listnews" => $listnews,
            "cats" => Category::findAll(),
            "dateTo" => $dateTo,
            "dateFrom" => $dateFrom,
            "filter" => $filter,
            "cat" => $cat,
            "limit" => $limit,
            "page" => $page
        );

        return $this->view->data = $data;

    }

    public function newAction()
    {

        $data = array(
            "langs" => Lang::findAll(),
            "cats" => Category::findAll()
        );
        $this->view->data = $data;
    }
}