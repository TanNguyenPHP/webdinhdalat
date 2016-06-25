<?php
namespace Webdinhdalat\Frontend\Controllers;

use Webdinhdalat\Modeldb\Models\Album;

class GalleryController extends ControllerBase
{
    public function indexAction()
    {
        $data = Album::findPicOfAlbum();
        return $this->view->data = $data;
    }
}

