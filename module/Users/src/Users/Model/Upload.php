<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Model;

class Upload{
    public $id;
    public $filename;
    public $label;
    public $user_id;
    
    public function setPassword($clear_password) {
        $this->password = md5($clear_password);
    }
    
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->filename = (isset($data['filename'])) ? $data['filename'] : NULL;
        $this->label = (isset($data['label'])) ? $data['label'] : NULL;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : NULL;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}