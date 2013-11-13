<?php

namespace Libs;

use Libs\Globals;

class Templater {
    private static $_template = 'Default';
    
    public function __construct($template = null) {
        if($template) {
            self::$_template = $template;
        }
    }
    
    public static function render($_template, $date = array()) {
        $content = self::getContent($_template);
        $templates_date = '';
        preg_match_all('/{{[ ]*([a-z0-9 ]+)[ ]*}}/i', $content, $templates_date);
        $replace_date = array();
        foreach($templates_date[0] as $td_key => $td) {
            $replace_date['/'.$td.'/'] = $date[trim($templates_date[1][$td_key], ' ')];
        }
        return self::replacer($content, $replace_date);
    }
    
    private static function getContent($_template) {
        $template = Globals::getDocumentRoot() . '/src/Resources/Templates/' . self::$_template . '/';
        if(is_file($template . $_template . '.html')) {
            $content = file_get_contents($template . $_template . '.html');
        } else {
            $content = file_get_contents($template . 'index.html');
        }
        
        return $content;
    }
    
    private static function replacer($content, $repl_array = array()) {
        return preg_replace(array_keys($repl_array), array_values($repl_array), $content);
    }
}