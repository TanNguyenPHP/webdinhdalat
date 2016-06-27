<?php
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Album;
use Webdinhdalat\Modeldb\Models\Picture;

class GalleryController extends ControllerBase
{
    public function indexAction()
    {
        $data = Album::findAlbumOfPicPaging('1', '4');// load page 1

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
        $album = Album::findAlbumOfPicPaging($page, $limit);
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
}

