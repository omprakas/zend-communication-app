<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Form;
use Zend\InputFilter\InputFilter;
class LoginFilter extends InputFilter{
    public function __construct() {
        $this->add(array(
            'name' => 'email',
            'required' => TRUE,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => TRUE
                    )
                )
            )
        ));
                
        $this->add(array(
            'name' => 'password',
            'required' => TRUE
        ));
        
    }
}

