<?php

namespace Libs;

class Route {
    
    private $_date      = array();
    private $_resources = array();
    
    public function add($url, $controller, $recursive = true) {
        $url_key = trim($url, '/');
        $_ca = explode(':',$controller);
        $object = "\Controller\\".$_ca[0];
        $date = new $object;
        if($recursive) {
            foreach(get_class_methods($date) as $method) {
                if(preg_match('/(.*)Action/', $method, $match)) {
                    $this->add($url . '/' . (($match[1] == 'index') ? '' : $match[1]), $controller . ':' . $match[1], false);
                }
            }
        } else {
            $this->_date[$url_key] = '$obj = new ' . $object . '(); return $obj->' . ((key_exists(1, $_ca) ? $_ca[1] : 'index') . 'Action();');
        }
    }
    
    public function render() {
        $request = Globals::getRequest();
        $path = $request->getPathInfo();
        $match = false;
        foreach($this->_resources as $u => $file) {
            if(($u == '/'.$path)) {
                echo $file;
                $match = true;
            }
        }
        if(!$match) {
            foreach($this->_date as $u => $response) {
                $_resp = eval($response);
                if(preg_match("#^$u$#", $path) && ($_resp instanceof Response)) {
                    $this->renderView($_resp);
                    $match = true;
                }
            }
        }
        if(!$match) {
            $page404 = new \Controller\Page404();
            $this->renderView($page404->indexAction());
        }
    }
    
    /**
     * @param Response $response
     */
    public function renderView($response) {
        return $response->send();
    }
    
    public function registerResources($template, $sub = '') {
        $tpl_dir = 'src/Resources/Templates/' . $template . $sub;
        $stpl_dir = scandir($tpl_dir);
        foreach($stpl_dir as $fd) {
            if(($fd == '.') || ($fd == '..')) { continue; }
            if(is_dir($tpl_dir . '/' . $fd)) {
                $this->registerResources($template, $sub . '/' . $fd);
            } else {
                if(pathinfo('src/Resources/Templates/' . $template . $sub . '/' . $fd)['extension'] != 'html') {
                    $this->addResource('/resources' . $sub . '/' . $fd, 'src/Resources/Templates/' . $template . $sub . '/' . $fd);
                }
            }
        }
    }
    
    private function addResource($route, $file) {
        $this->_resources[$route] = file_get_contents($file);
    }
}