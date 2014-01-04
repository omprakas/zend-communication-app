<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class IndexController extends AbstractActionController{
    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }
    public function registerAction() {
        $view = new ViewModel();
        $view->setTemplate('users/index/new-user');
        return $view;
    }
    
    public function loginAction() {
        $view = new ViewModel();
        $view->setTemplate('users/index/login');
        return $view;
    }
}

