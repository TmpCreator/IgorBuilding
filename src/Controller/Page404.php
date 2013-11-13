<?php

namespace Controller;

use Libs\Extensions\Controller;
use Libs\Response;

class Page404 extends Controller {
    public function indexAction() {
        return new Response('index',array(
            'title' => '404',
            'body'  => '404',
        ), 404);
    }
}