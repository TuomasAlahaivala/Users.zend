<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Model;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Session\Container;
 class Users implements InputFilterAwareInterface
 {
     public $user_name;
     public $user_pass;
     public $user_level;
     public $email;
     public $id;
     protected $inputFilter;
     
     public function exchangeArray($data)
     {
         /*$this->id     = (!empty($data->id)) ? $data->id : null;
         $this->user_name     = (!empty($data->user_name)) ? $data->user_name : null;
         $this->user_level     = (!empty($data->user_level)) ? $data->user_level : null;
         $this->user_pass      = (!empty($data->user_pass)) ? $data->user_pass : null;
         $this->email     = (!empty($data->email)) ? $data->email : null;*/
         
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->user_name     = (!empty($data['user_name'])) ? $data['user_name'] : null;
         $this->user_level     = (!empty($data['user_level'])) ? $data['user_level'] : null;
         $this->user_pass      = (!empty($data['user_pass'])) ? $data['user_pass'] : null;
         $this->email     = (!empty($data['email'])) ? $data['email'] : null;

     }
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }
     public function saveTosession($data){
         
         if(!empty($this->user_name)){
           //echo $this->user_name;
            $user_session = new Container('user');
            $user_session->user_name = $data->user_name;
            $user_session->user_level = $data->user_level;
         }
         return;
     }
     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             /*$inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));*/

             $inputFilter->add(array(
                 'name'     => 'user_name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'user_pass',
                 'required' => true,
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'min' => 5,
                             'max' => 128,
                         ),
                     ),
                 ),
             ));
             
             /*$inputFilter->add(array(
                 'name'     => 'email',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'EmailAddress',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));*/

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }