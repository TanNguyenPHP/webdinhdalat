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
        try {
            $cat = Category::findConditionAll('', $id, '1');
            $cats = Category::findConditionAll($cat[0]->id, '', '1');
            $data = News::findAllNewsOfCategory($cat[0]->id, '1', '1', '4');//$cat = '', $id_lang = '',$page='',$limit=''//Thay đổi tham số thành dynamic;
            if ($data == null) {
                $data = News::findAllNewsOfCategory($cats[0]->id, '1', '1', '4');
                $cat = $cats;
                if ($data != null) {
                    $this->tag->prependTitle($cats[0]->title . " | ");
                    self::setMetaDescription($cats[0]->meta_description);
                }
            } else {
                $this->tag->prependTitle($cat[0]->title . " | ");
                self::setMetaDescription($cat[0]->meta_description);
            }
            return $this->view->data = array('data' => $data, 'cat' => $cat, 'catid' => $cat[0]->id);
        } catch (\Exception $e) {
            return $this->response->redirect('/index');
        }
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
            self::setMetaDescription($data->seo_desc);
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