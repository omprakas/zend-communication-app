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

use Users\Model\Upload;

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
    
    public function uploadAction() {
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $userTable = $this->getServiceLocator()->get('UserTable');
        $userEmail = $this->getAuthService()->getStorage()->read();
        
        $user = $userTable->getUserByEmail($userEmail);
        $form = $this->getServiceLocator()->get('UploadForm');
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }
    
    public function getFileUploadLocation() {
        //Fetch Configuration from Module Config
        $config = $this->getServiceLocator()->get('config');
        return $config['module_config']['upload_location'];
    }
    
    public function processUploadAction () {
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $userTable = $this->getServiceLocator()->get('UserTable');
        $userEmail = $this->getAuthService()->getStorage()->read();
        
        $user = $userTable->getUserByEmail($userEmail);
        
        $uploadFile = $this->params()->fromFiles('fileupload');
        $request = $this->getRequest();
        $form = $this->getServiceLocator()->get('UploadForm');
        $form->setData($request->getPost());
        
        if ($form->isValid()){
            //Fetch Configuration from Module Config
            $uploadPath = $this->getFileUploadLocation();
            $upload = new Upload();
            //Save Uploaded file
            $adapter = new \Zend\File\Transfer\Adapter\Http();
            $adapter->setDestination($uploadPath);
            if ($adapter->receive($uploadFile['name'])){
                //File upload successfull
                $exchange_data = array();
                $exchange_data['label'] = $request->getPost()->get('label');
                $exchange_data['filename'] = $uploadFile['name'];
                $exchange_data['user_id'] = $user->id;
                
                $upload->exchangeArray($exchange_data);
                $uploadTable = $this->getServiceLocator()->get('UploadTable');
                
                $uploadTable->saveUpload($upload);
                
                return $this->redirect()->toRoute('users/upload-manager', array('action' => 'index'));
            }
        }
    }
    public function deleteAction() {
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $uploadId = $this->params()->fromRoute('id');
        
        $upload = $uploadTable->getUpload($uploadId);
        $uploadPath = $this->getFileUploadLocation();
        // Remove File
	unlink($uploadPath ."/" . $upload->filename); 
        
        $uploadTable->deleteUpload($uploadId);
        $this->redirect()->toRoute('users/upload-manager', array('action' => 'index'));
    }
}
