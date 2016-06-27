<?php
namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\News;
use Webdinhdalat\Modeldb\Models\Category;
use Phalcon\Di;

class NewsController extends ControllerBase
{

    public function indexAction($id = "")
    {
        $catid = "3";
        $data = News::findAllNewsOfCategory($catid, '1', '1', '4');//$cat = '', $id_lang = '',$page='',$limit=''//Thay đổi tham số thành dynamic;
        if ($id != "") {
            $data = News::findAllNewsOfCategory($id, '1', '1', '4');
            $_cat = Category::findFirstByid($id);
            $catid = $_cat->id;
            $this->tag->prependTitle($_cat->name . " | ");
        } else {
            $_cat = Category::findFirstByid($catid);
            $catid = $_cat->id;
            $this->tag->prependTitle($_cat->name . " | ");
        }
        $cats = Category::findParent('2');
        return $this->view->data = array('data' => $data, 'cats' => $cats, 'catid' => $catid);
    }

    public function detailAction($id)
    {
        if (!$this->request->isPost()) {
            $data = News::findFirstByslug("$id");
            if (!$data) {
                $this->flash->error("Bài viết không tồn tại");
                return $this->response->redirect('/index');
            }
            $this->tag->prependTitle($data->seo_title . " | ");
            return $this->view->data = $data;
        }
    }

    public function loadmorenewsAction()
    {
        $cat = "3";
        $limit = 4;
        $page = 1;
        $id_lang = "1";
        $endpage = 'false';

        if (isset($_POST['page']))
            $page = (int)$_POST['page'];
        if (isset($_POST['endpage']))
            $endpage = $_POST['endpage'];
        if (isset($_POST['catid']))
            $cat = $_POST['catid'];

        if ($endpage == 'true') {
            $data = array(
                "endload" => 'end',
                "nextpage" => $page,
                "endpage" => $endpage
            );
            return $this::sendJson($data);
        }
        $listnews = News::findNewsPaging($page, $limit, "", "", "", $cat, $id_lang);
        $news = array();
        foreach ($listnews->items as $item) {
            $news[] = array(
                'slug' => $item->slug,
                'title' => $item->title,
                'datecreate' => \DateTime::createFromFormat('YmdHis', $item->datecreate)->format('d/m/Y'),
                'avatar_image' => $item->avatar_image,
                'content_short' => $item->content_short
            );
        }
        if ($page == $listnews->last) {
            $endpage = 'true';
        }
        $data = array(
            "listnews" => $news,
            "nextpage" => $listnews->next,
            "endpage" => $endpage
        );
        return $this::sendJson($data);
    }
}