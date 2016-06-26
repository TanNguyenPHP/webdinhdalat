<?php
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Album;
use Webdinhdalat\Modeldb\Models\Picture;

class GalleryController extends ControllerBase
{
    public function indexAction()
    {
        $data = Album::findAlbumOfPicPaging('1', '4','','','1');// load page 1

        return $this->view->data = $data;
    }

    public function morealbumAction()
    {
        $limit = 4;
        $page = 2;
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
        $album = Album::findAlbumOfPicPaging($page, $limit,'','1');
        $albums = array();
        $id_albums = array();
        foreach ($album->items as $item) {
            $albums[] = array(
                'name' => $item->name,
                'id' => $item->id
            );
            $id_albums[] = array($item->id);
        }
        $pic = Picture::findPicOfAlbum($id_albums);

        if ($page == $album->last) {
            $endpage = 'true';
        }
        $data = array(
            "albums" => $albums,
            "pic"=> $pic,
            "nextpage" => $album->next,
            "endpage" => $endpage
        );
        return $this::sendJson($data);
    }
}

