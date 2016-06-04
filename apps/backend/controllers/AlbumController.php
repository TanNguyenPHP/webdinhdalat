<?php
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\Album;
use Webdinhdalat\Commons\ParamsConstant as params;
use Webdinhdalat\Commons\RemoveUnicode;

class AlbumController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function createAction()
    {
        $album = new Album();

        $album->name = $this->request->getPost("name");
        $folder = RemoveUnicode::stripUnicode($album->name);
        $dir = params::pathfolderpicture . $folder;
        $result = parent::createFolder($dir);
        if ($result == 1) {
            $album->folder = $folder;
            $album->dir = $dir;
            $album->desc = $this->request->getPost("desc");
            $album->datecreate = date('YdmHis');
            $album->is_del = '0';
            if ($album->save())
                return $this->response->redirect('backend/album/new');
        }else if($result == 0 || $result == 3)
        {
            $this->flash->error("Không tạo folder");
            return $this->response->redirect('backend/album/index');
        }else if($result == 2)
        {
            $this->flash->error("Folder đã được tạo");
            return $this->response->redirect('backend/album/index');
        }

    }
    public function newAction()
    {

    }
}

