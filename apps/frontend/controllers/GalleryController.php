<?php
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Album;
use Webdinhdalat\Modeldb\Models\Picture;
Use Webdinhdalat\Modeldb\Models\Menu;

class GalleryController extends ControllerBase
{
    public function indexAction()
    {
        $data = Album::findAlbumOfPicPagingShowWeb('1', '4');// load page 1

        $this->assets
            ->addCss('/css/backend/fancybox/jquery.fancybox.css')
            ->addCss('/css/backend/fancybox/jquery.fancybox-buttons.css')
            ->addCss('/css/backend/fancybox/jquery.fancybox-thumbs.css');
        $this->assets
            ->addJs('/js/jquery.mousewheel-3.0.6.pack.js')
            ->addJs('/js/jquery.fancybox.js')
            ->addJs('/js/jquery.fancybox-buttons.js')
            ->addJs('/js/jquery.fancybox-thumbs.js');
        $menu = Menu::findFirstByid('3');
        $this->tag->prependTitle($menu->title . " | ");
        self::setMetaDescription($menu->meta_description);
        return $this->view->data = $data;
    }

    public function morealbumAction()
    {
        $limit = 4;
        $page = 1;
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
            return $this::sendJson($data);
        }
        $album = Album::findAlbumOfPicPagingShowWeb($page, $limit);
        $albums = array();
        foreach ($album->items as $item) {
            $albums[] = array(
                'name' => $item->name,
                'id' => $item->id,
                'dir' => $item->dir
            );

        }

        if ($page == $album->last||$album->items->count() == 0) {
            $endpage = 'true';
        }
        $data = array(
            "albums" => $albums,
            "nextpage" => $album->next,
            "endpage" => $endpage
        );
        return $this::sendJson($data);
    }
    public function detailalbumAction()
    {
        $id = '';
        if (isset($_POST['id']))
            $id = $_POST['id'];
        $data = Picture::findPicOfAlbum($id);
        $piclist = array();
        foreach ($data as $item)
        {
            $pic = array('href' => '\\'. $item->dir);
            array_push($piclist, $pic);
        }
        return $this::sendJson($piclist);
    }
}

