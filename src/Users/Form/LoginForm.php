<?php
namespace Users\Form;

 use Zend\Form\Form;

 class LoginForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('login');

         $this->add(array(
             'name' => 'user_name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'User Name',
             ),
         ));
         $this->add(array(
             'name' => 'user_pass',
             'type' => 'Password',
             'options' => array(
                 'label' => 'Password',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Login',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }