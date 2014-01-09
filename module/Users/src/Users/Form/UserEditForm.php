<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Form;
use Zend\Form\Form;
class UserEditForm extends Form{
    public function __construct($name = NULL) {
        parent::__construct('Edit User');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));
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
            
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value'=> 'Save'            
            ),
        ));
    }
}