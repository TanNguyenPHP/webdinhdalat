<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 6/26/2016
 * Time: 12:26 AM
 */
namespace Webdinhdalat\Frontend\Controllers;
use Webdinhdalat\Modeldb\Models\Menu;

class MapController extends ControllerBase
{
    public function IndexAction()
    {
        if (!$this->request->isPost()) {
            $data = Menu::findFirst("id = '4'");
            if (!$data) {
                $this->flash->error("Bài viết không tồn tại");
                return $this->response->redirect('/index');
            }
            $this->tag->prependTitle($data->title . " | ");
            self::setMetaDescription($data->meta_description);
            return $this->view->data = $data;
        }
    }
}