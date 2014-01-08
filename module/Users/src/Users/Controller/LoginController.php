<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Users\Form\LoginFilter;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DBTableAuthAdapater;
class LoginController extends AbstractActionController{
    protected $authservice;
    public function getAuthService() {
        if (!$this->authservice){
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $dbTableAuthAdapter = new DBTableAuthAdapater($dbAdapter, 'user', 'email', 'password', 'MD5(?)');
            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $this->authservice = $authService;
        }
        return $this->authservice;
    }
    
    public function confirmAction() {
        $user_email = $this->getAuthService()->getStorage()->read();
        $viewModel = new ViewModel(array(
            'user_email' => $user_email
        ));
        return $viewModel;
    }
    
    public function indexAction() {
        $form = new LoginForm();
        $viewModel = new ViewModel(array(
            "form" => $form
        ));
        return $viewModel;
    }
    
    public function processAction() {
        if (!$this->request->isPost()){
            return $this->redirect()->toRoute(NULL,
                    array(
                        'controller' => 'login',
                        'action' => 'index'
                    )
            );
        }
        $post = $this->request->getPost();
        $form = new LoginForm();
        $inputFilter = new LoginFilter();
        $form->setInputFilter($inputFilter);
        $form->setData($post);
        if (!$form->isValid()){
            $model = new ViewModel(array(
                'error' => TRUE,
                  'form' => $form
            ));
            $model->setTemplate('users/login/index');
            return $model;
         } else {
             //check authentication
             $this->getAuthService()->getAdapter()
                     ->setIdentity($this->request->getPost('email'))         
                     ->setCredential($this->request->getPost("password"));
             $result = $this->getAuthService()->authenticate();
             if ($result->isValid()){
                 $this->getAuthService()->getStorage()
                         ->write($this->request->getPost('email'));
                 return $this->redirect()->toRoute(NULL, array(
                     'controller' => 'login',
                     'action' => 'confirm'
                 ));
             } else {
                 $model = new ViewModel(array(
                     'error' => true,
                     'form' => $form
                 ));
                 $model->setTemplate('users/login/index');
                 return $model;
             }
         }  
    }
    
    public function loginAction() {
        $viewModel = new ViewModel();
        return $viewModel;
    }
}

