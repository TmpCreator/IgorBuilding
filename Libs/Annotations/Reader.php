<?php

namespace Libs\Annotations;

class Reader {

    private $class;
    private $properties = array();
    private $keyPattern = "[A-z0-9\_\-]+";
    private $endPattern = "[ ]*(?:@|\r\n|\n)";

    public function __construct($class) {
        $this->class = $class;
        $reflection = new \ReflectionClass($class);
        $this->getProporteries($reflection);
    }
    
    private function getProporteries($reflection) {
        foreach($reflection->getProperties() as $proporterie) {
            $this->properties[] = $proporterie->getName();
        }
    }
    
    private function getAssocParams() {
        $annotaions = array();
        foreach($this->properties as $proporterie) {
            $refl = new \ReflectionProperty($this->class, $proporterie);
            $annotaions[$proporterie] = $this->parseAnnotation($refl->getDocComment());
        }
        
        return $annotaions;
    }
    
    private function parseAnnotation($annotation) {
        $pattern = "/@(?=(.*)" . $this->endPattern . ")/U";

        preg_match_all($pattern, $annotation, $matches);

        $annotations = array();
        
        foreach ($matches[1] as $rawParameter) {
            if (preg_match("/^(" . $this->keyPattern . ") (.*)$/", $rawParameter, $match)) {
                if (isset($this->parameters[$match[1]])) {
                    $annotations[$match[1]] = array_merge((array) $this->parameters[$match[1]], (array) $match[2]);
                } else {
                    $annotations[$match[1]] = $this->parseValue($match[2]);
                }
            } else if (preg_match("/^" . $this->keyPattern . "$/", $rawParameter, $match)) {
                $annotations[$rawParameter] = TRUE;
            } else {
                $annotations[$rawParameter] = NULL;
            }
        }
        
        return $annotations;
    }
    private function parseValue($originalValue) {
        if ($originalValue && $originalValue !== 'null') {
            // try to json decode, if cannot then store as string
            if (($json = json_decode($originalValue, TRUE)) === NULL) {
                $value = $originalValue;
            } else {
                $value = $json;
            }
        } else {
            $value = NULL;
        }

        return $value;
    }

    public function getParameters() {
        return $this->getAssocParams();
    }
}
