<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Http\Headers;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class UploadManagerController extends AbstractActionController{
    protected $authservice;
    
    public function getAuthService() {
        if (!$this->authservice){
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }
    public function indexAction() {
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $userTable = $this->getServiceLocator()->get('UserTable');
        $userEmail = $this->getAuthService()->getStorage()->read();
        
        $user = $userTable->getUserByEmail($userEmail);
        
        $viewModel = new ViewModel(array(
            'myUploads' => $uploadTable->getUploadsByUserId($user->id)
        ));
        return $viewModel;
    }   
}
