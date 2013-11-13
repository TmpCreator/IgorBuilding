<?php

namespace Libs;

class Response {
    private $content;
    private $status_code;
    private $headers;
    private $template;
     
    /**
     * Создает ответ сервера
     * 
     * @param string $content                       содержимое ответа
     * @param integer $status_code                  HTTP-статус код ответа
     * @param array $headers                        HTTP-заголовки ответа
     */
    public function __construct($template, $content, $status_code = 200, $headers = array()) {
        // устанавливаем свойства класса
        $this->content      = $content;
        $this->status_code  = $status_code;
        $this->headers      = $headers;
        $this->template     = $template;
    }
     
    public function setStatusCode($status_code) {
        $this->status_code = $status_code;
    }
     
    public function setHeader($header) {
        $this->headers[] = $header;
    }
     
    public function send() {
        // выслать код статуса HTTP
        header('HTTP/1.1 ' . $this->status_code);
        // отправить заголовки HTTP
        foreach ( $this->headers as $header ) {
            header($header);
        }
        // отправить содержимое ответа
        echo Templater::render($this->template, $this->content);
    }
}