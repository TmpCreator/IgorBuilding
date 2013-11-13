<?php
namespace Libs;
 
class Autoload {
    const debug = 1;
    
    public function __construct(){}
    
    public static function autoload($file) {
        $file = str_replace('\\', '/', $file);
        $path = getenv("DOCUMENT_ROOT") . '/';
        $filepath = getenv("DOCUMENT_ROOT") . '/' . $file . '.php';
        
        if (file_exists($filepath)) {
            if(Autoload::debug) {
                Autoload::StPutFile(('подключили ' .$filepath));
            }
            require_once($filepath);
        } else { 
            $flag = true;
            if(Autoload::debug) {
                Autoload::StPutFile(('начинаем рекурсивный поиск'));
            }
            Autoload::recursive_autoload($file, $path, $flag);
        }
    }

    public static function recursive_autoload($file, $path, &$flag) {
        if (FALSE !== ($handle = opendir($path)) && $flag) {
            while (FAlSE !== ($dir = readdir($handle)) && $flag) {
                if (strpos($dir, '.') === FALSE) {
                    $path2 = $path .'/' . $dir;
                    $filepath = $path2 . '/' . $file . '.php';
                    if(Autoload::debug) {
                        Autoload::StPutFile(('ищем файл <b>' .$file .'</b> in ' .$filepath));
                    }
                    if (file_exists($filepath)) {
                        if(Autoload::debug) {
                            Autoload::StPutFile(('подключили ' .$filepath ));
                        }
                        $flag = FALSE;
                        require_once($filepath);
                    } else {
                        Autoload::recursive_autoload($file, $path2, $flag); 
                    }
                }
            }
            closedir($handle);
        }
    }
  
    private static function StPutFile($data) {
        $dir = getenv("DOCUMENT_ROOT") .'/Logs/autoload.log.html';
        $file = fopen($dir, 'a');
        
        flock($file, LOCK_EX);
        fwrite($file, ('| ' .$data .'  =>  ' .date('d.m.Y H:i:s') .' |' .PHP_EOL));
        flock($file, LOCK_UN);
        fclose($file);
    }
}
\spl_autoload_register('Libs\Autoload::autoload');