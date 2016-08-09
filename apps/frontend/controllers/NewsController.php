<?php
namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\News;
use Webdinhdalat\Modeldb\Models\Category;
use Webdinhdalat\Modeldb\Models\Menu;
use Phalcon\Di;
use Webdinhdalat\Commons\ParamsCookie;

class NewsController extends ControllerBase
{
    public function indexAction($id = "")
    {
        $is_status = "1";
        $page = "1";
        $limit = "4";
        $menutitle = "";

        try {
            $menu = Menu::findFirst("slug_category = '$id'");
            if (!$menu) {
                $menutitle = $_COOKIE[ParamsCookie::menutitle];
            } else {
                $this::SetCookie(ParamsCookie::menutitle, $menu->name);
                $menutitle = $menu->name;
            }
            $cat = Category::findConditionAll('', $id, $is_status);
            $cats = Category::findConditionAll($cat[0]->id, '', $is_status);
            $data = News::findAllNewsOfCategory($cat[0]->id, '', $page, $limit);//$cat = '', $id_lang = '',$page='',$limit=''//Thay đổi tham số thành dynamic;
            $menusub = $cats;
            if ($cat[0]->pid != 0)
                $menusub = Category::findConditionAll($cat[0]->pid, '', $is_status);
            if (!isset($_COOKIE[ParamsCookie::menusub]))
                $this::SetCookie(ParamsCookie::menusub, '2');
            if ($data->count() == 0) {
                $data = News::findAllNewsOfCategory($cats[0]->id, '', $page, $limit);
                $cat = $cats;
                if ($data->count() != 0) {
                    $this->tag->prependTitle($cats[0]->title . " | ");
                    self::setMetaDescription($cats[0]->meta_description);
                }
            } else {
                $this->tag->prependTitle($cat[0]->title . " | ");
                self::setMetaDescription($cat[0]->meta_description);
            }
            return $this->view->data = array('data' => $data,
                'cat' => $cat,
                'catid' => $cat[0]->id,
                'menutitle' => $menutitle,
                'menusub' => $menusub);
        } catch (\Exception $e) {
            return $this->response->redirect('/index');
        }
    }

    public function detailAction($id)
    {
        if (!$this->request->isPost()) {
            try {
                $menutitle = $_COOKIE[ParamsCookie::menutitle];
                $data = News::findFirstByslug("$id");
                if (!$data) {
                    $this->flash->error("Bài viết không tồn tại");
                    return $this->response->redirect('/index');
                }
                $this->tag->prependTitle($data->seo_title . " | ");
                self::setMetaDescription($data->seo_desc);
                return $this->view->data = array('data' => $data,
                    'menutitle' => $menutitle,
                    'menusub' => $_COOKIE[ParamsCookie::menusub]);
            } catch (\Exception $e) {
                return $this->response->redirect('/index');
            }

        }
    }

    public function loadmorenewsAction()
    {
        $cat = "3";
        $limit = 4;
        $page = 1;

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
        $listnews = News::findNewsPaging($page, $limit, "", "", "", $cat, '');
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