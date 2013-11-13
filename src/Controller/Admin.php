<?php

namespace Controller;

use Libs\Extensions\Controller;
use Libs\Response;
use Libs\Former\Form;

class Admin extends Controller {
    public function indexAction() {
        return new Response('admin/index', array(
            'title' => 'Admin | LogIn',
            'body'  => $this->getLoginForm(),
        ));
    }
    public function validateAction() {
        return new Response('admin/index', array(
            'title' => 'Admin | LogIn',
            'body'  => 'UUUUUUUUUUUH',
        ));
    }
    
    private function getLoginForm() {
        $form = new Form('/admin/validate');
        $form->add('login', 'text', 'LogIn', array(
            'style' => 'color: #f00;',
        ));
        return $form->build();
    }
}