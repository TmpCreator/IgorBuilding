<?php

namespace Libs;

class RedirectResponse {
    private $location;

    public function __construct($location) {
        $this->location = $location;
    }
    
    public function send() {
        // выслать код статуса HTTP
        header("Location: " . $this->location);
    }
}