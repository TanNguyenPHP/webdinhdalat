<?php

namespace Webdinhdalat\Frontend\Controllers;

use Phalcon\Mvc\Controller;


class ControllerBase extends Controller
{
    public function initialize()
    {
        // Add some local CSS resources
        $this->assets
            ->addCss('css/frontend/main.css');

    }
}
