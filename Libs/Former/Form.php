<?php

namespace Libs\Former;

use Libs\Globals;

class Form {
    private $fields     = array();
    private $validators = array();
    private $action;
    private $method;
    
    /**
     * @var \Libs\Templater
     */
    private $templater;
    
    public function __construct($action, $method = 'POST') {
        $this->templater = Globals::getTemplater();
        $this->action = $action;
        $this->method = $method;
    }
    
    /**
     * 
     * @param string $type
     * @param string $label
     * @param array  $attr
     */
    public function add($name, $type, $label, array $attr = array()) {
        $this->fields[$name] = array(
            'type'  => $type,
            'label' => $label,
            'attr'  => $attr,
        );
    }
    
    public function addValidator($name, $validator) {
        $this->validators[$name] = $validator;
    }
    
    public function build() {
        $fields = '';
        foreach($this->fields as $name => $field) {
            $attr = '';
            foreach($field['attr'] as $key => $value) {
                $attr .= $this->templater->render('../../../../Libs/Former/View/attr', array(
                    'name'  => $key,
                    'value' => $value,
                ));
            }
            $fields .= $this->templater->render('../../../../Libs/Former/View/Type/' . $field['type'], array(
                'name'  => $name,
                'attrs' => $attr,
                'label' => $field['label'],
            ));
        }
        return $this->templater->render('../../../../Libs/Former/View/form', array(
            'action'    => $this->action,
            'method'    => $this->method,
            'fields'    => $fields,
        ));
    }
    
    public function validate() {
        
    }
}
