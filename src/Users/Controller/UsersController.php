<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\Users;
use Users\Form\LoginForm;
use Users\Form\RegistrationForm;
 use Zend\Session\Container;
 class UsersController extends AbstractActionController
 {
     protected $usersTable;


     public function indexAction()
     {
        $loginform = new LoginForm();
         $loginform->get('submit')->setValue('Login');
         $error = "";
         
        $user_session = new Container('user');
        
         $request = $this->getRequest();
         if($request->isPost()){
             //echo "76567567";
             $user = new Users();
             $loginform->setInputFilter($user->getInputFilter());
             $loginform->setData($request->getPost());
             //echo "123456";
             if($loginform->isValid()){
                 //echo "123";
                 $user->exchangeArray($loginform->getData());
                $result = $this->getUsersTable()->checkLogin($user);
                if(!isset($result->virhe)){
                    
                    $user->saveTosession($result);
                }else{
                    //echo $result->virhe;
                    $error = $result->virhe;
                }
                 // Redirect to list of Users
                 //return $this->redirect()->toRoute('users');
             }
         }

         return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchAll(),
            'loginform' => $loginform,
            'error' => $error,
             'user_info' => $user_session
         ));
     }
     public function logoutAction(){
         $user_session = new Container('user');
         $user_session->getManager()->destroy();
         return $this->redirect()->toRoute('users');
     }
     public function registryAction()
     {
         $form = new RegistrationForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $users = new Users();
             $form->setInputFilter($users->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $users->exchangeArray($form->getData());
                 $this->getUsersTable()->saveUser($users);
                 $users->saveTosession();
                 // Redirect to list of Users
                 return $this->redirect()->toRoute('users');
             }
         }
         return array('form' => $form);
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
     public function getUsersTable()
     {
         if (!$this->usersTable) {
             $sm = $this->getServiceLocator();
             $this->usersTable = $sm->get('Users\Model\UsersTable');
         }
         return $this->usersTable;
     }
 }