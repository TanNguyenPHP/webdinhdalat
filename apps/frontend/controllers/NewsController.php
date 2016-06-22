<?php
namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\News;
use Phalcon\Di;

class NewsController extends ControllerBase
{

    public function indexAction()
    {
        $this->tag->prependTitle("Tin tức | ");
    }

    public function loadmorenewsAction()
    {

        $cat = "2";
        $limit = 4;
        $page = 1;
        $id_lang = "1";
        $endpage = 'false';


        if (isset($_POST['page']))
            $page = (int)$_POST['page'];
        if (isset($_POST['endpage']))
            $endpage = $_POST['endpage'];

        if ($endpage == 'true') {
            $data = array(
                "endload" => 'end',
                "nextpage" => $page,
                "endpage" => $endpage
            );
            return json_encode($data);
        }
        $listnews = News::findNewsPaging($page, $limit, "", "", "", $cat, $id_lang);
        $news = array();
        foreach ($listnews->items as $item) {
            $news[] = array(
                'id' => $item->id,
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
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($data);
    }
}

