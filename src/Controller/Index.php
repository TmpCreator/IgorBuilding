<?php

namespace Controller;

use Libs\Extensions\Controller;
use Libs\Response;

class Index extends Controller {
    public function indexAction() {
        return new Response('index', array(
            'title' => 'Index',
            'body'  => 'index content',
        ));
    }
    public function aboutAction() {
        return new Response('index', array(
            'title' => 'About',
            'body'  => 'about content',
        ));
    }
    public function contaktAction() {
        return new Response('index', array(
            'title' => 'Contakt',
            'body'  => 'contakt content',
        ));
    }
}