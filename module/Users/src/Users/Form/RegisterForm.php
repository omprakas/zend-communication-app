<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//filename : module/Users/src/Users/Form/Register
namespace Users\Form;
use Zend\Form\Form;
class RegisterForm extends Form{
    public function __construct($name = NULL) {
        parent::__construct('Register');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
		'required' => 'required'
            ),
            'options' => array(
                'label' => 'Full Name'
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
		'required' => 'required'
            ),
            'options' => array(
                'label' => 'Email'
            ),
            'filters' => array(
                'name' => 'StringTrim'
            ),
            
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Password'
            ),
        ));
        $this->add(array(
            'name' => 'confirm_password',
            'attributes' => array(
                'type' => 'password',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Confirm Password'
            ),
           
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
		'value'=> 'Register'            
            ),
        ));
    }
}

