<?php

namespace Model;

class User {
    
    /**
     * unique identifier
     * @MyParam myvalue
     * @ORM\String
     */
    private $id;
    
    /**
     * user name
     * @MyParam myvalue
     * @ORM\String
     */
    private $name;
    
    /**
     * Get id
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
}

