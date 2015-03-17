<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Users\Model;

 use Zend\Db\TableGateway\TableGateway;
use stdClass;
 class UsersTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getUser($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }
     public function checkLogin($data)
     {
         $user_name = $data->user_name;
         $user_pass = md5($data->user_pass);
         $rowset = $this->tableGateway->select(array('user_name' => $user_name,'user_pass' => $user_pass));

         $row = $rowset->current();
         //print_r($row);
         if (!$row) {
            // echo "978978";
             $row = new stdClass();
             $row->virhe = "Virhe tunnuksisssa";
         }
         return $row;
     }
     public function saveUser(Users $Users)
     {
         $data = array(
             'user_name' => $Users->user_name,
             'user_pass' => $Users->user_pass,
             'email'  => $Users->email,
         );

         $id = (int) $Users->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getAlbum($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteUser($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }