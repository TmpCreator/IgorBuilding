<?php

namespace Libs\Extensions;

use Libs\Globals;

class Controller {
    protected $request;
    protected $templater;
    
    public function __construct() {
        $this->request   = Globals::getRequest();
        $this->templater = Globals::getTemplater();
    }
}
