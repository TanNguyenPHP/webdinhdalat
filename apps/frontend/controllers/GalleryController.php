<?php
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Album;

class GalleryController extends ControllerBase
{
    public function indexAction()
    {
        $data = Album::findAlbumOfPicPagingShowWeb('1', '4');// load page 1
        $this->assets
            ->addCss('/js/unitegallery/css/unite-gallery.css')
            ->addCss('/js/unitegallery/themes/default/ug-theme-default.css');
        $this->assets
            ->addJs('/js/unitegallery/js/unitegallery.min.js')
            ->addJs('/js/unitegallery/js/ug-api.js')
            ->addJs('/js/unitegallery/js/ug-avia.js')
            ->addJs('/js/unitegallery/js/ug-carousel.js')
            ->addJs('/js/unitegallery/js/ug-common-libraries.js')
            ->addJs('/js/unitegallery/js/ug-functions.js')
            ->addJs('/js/unitegallery/js/ug-gallery.js')
            ->addJs('/js/unitegallery/js/ug-gridpanel.js')
            ->addJs('/js/unitegallery/js/ug-lightbox.js')
            ->addJs('/js/unitegallery/js/ug-panelsbase.js')
            ->addJs('/js/unitegallery/js/ug-strippanel.js')
            ->addJs('/js/unitegallery/js/ug-tabs.js')
            ->addJs('/js/unitegallery/js/ug-thumbsgeneral.js')
            ->addJs('/js/unitegallery/js/ug-thumbsstrip.js')
            ->addJs('/js/unitegallery/js/ug-tiledesign.js')
            ->addJs('/js/unitegallery/js/ug-tiles.js')
            ->addJs('/js/unitegallery/js/ug-touchslider.js')
            ->addJs('/js/unitegallery/js/ug-touchthumbs.js')
            ->addJs('/js/unitegallery/js/ug-video.js')
            ->addJs('/js/unitegallery/js/ug-theme-slider.js')
            ->addJs('/js/unitegallery/js/ug-zoomslider.js')
            ->addJs('/js/unitegallery/themes/default/ug-theme-default.js');
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
}

