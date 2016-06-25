<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 6/20/2016
 * Time: 4:32 PM
 */
namespace Webdinhdalat\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Webdinhdalat\Modeldb\Models\Menu;
use Webdinhdalat\Modeldb\Models\Language;

class MenuController extends ControllerBase
{
    public function indexAction()
    {
        $id_lang = "";

        if (isset($_GET['lang']))
            $id_lang = $_GET['lang'];

        $data = array(
            "langs" => Language::findAll(),
            "menus" => Menu::findall($id_lang)
        );

        return $this->view->data = $data;
    }

    public function editstatusAction()
    {
        $id = $this->request->getPost("id");
        $menu = Menu::findFirstByid($id);
        if ($menu->is_active == '0')
            $menu->is_active = '1';
        else
            $menu->is_active = '0';
        try {

            if (!$menu->save()) {
                foreach ($menu->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "Mở";
        if ($menu->is_active == '0')
            $data = 'Đóng';


        return $this::sendText($data);
    }
}