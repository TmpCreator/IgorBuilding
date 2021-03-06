<?php

namespace Libs;

class Request {
    /**
     * Получить путь запроса без строки запроса и имени выполняемого
     * скрипта
     * 
     * @return string
     */
    public function getPathInfo() {
        $request_uri = $_SERVER['REQUEST_URI'];
        $query_string = $_SERVER['QUERY_STRING'];
        $script_name = $_SERVER['SCRIPT_NAME'];
        $path_info = str_replace('?' . $query_string, '', $request_uri);
        $path_info = str_replace($script_name, '', $path_info);
        $path_info = trim($path_info, '/');
        return empty($path_info) ? '' : $path_info;
    }
     
    /**
     * Поиск и получение значения параметра зпроса
     * по ключу
     * 
     * @param string $key               искомый ключ параметра запроса
     * @return mixed                    значение параметра 
     *                                  или null если параметр не существует
     */
    public function get($key) {
        if ( key_exists($key, $_REQUEST) ) {
            return $_REQUEST[$key];
        } else {
            return null;
        }
    }
     
    /**
     * Проверяет существование параметра в запросе
     * по его ключу
     * 
     * @param string $key               проверяемый ключ
     * @return boolean
     */
    public function has($key)
    {
        return key_exists($key, $_REQUEST);
    }
}