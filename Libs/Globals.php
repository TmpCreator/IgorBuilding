<?php

namespace Libs;

use Libs as L;

class Globals {
    private static $document_root;
    private static $templater;
    private static $request;
    
    public function __construct($template = null) {
        self::$document_root = getenv("DOCUMENT_ROOT");
        self::$templater     = new L\Templater($template);
        self::$request       = new L\Request();
    }
    
    public static function getDocumentRoot() {
        return self::$document_root;
    }
    
    /**
     * @return \Libs\Templater
     */
    public static function getTemplater() {
        return self::$templater;
    }
    
    /**
     * @return \Libs\Request
     */
    public static function getRequest() {
        return self::$request;
    }
}