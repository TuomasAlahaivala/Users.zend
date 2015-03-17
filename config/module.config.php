<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
     'controllers' => array(
         'invokables' => array(
             'Users\Controller\Users' => 'Users\Controller\UsersController',
         ),
     ),
    'router' => array(
         'routes' => array(
             'users' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/users[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Users\Controller\Users',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
     'view_manager' => array(
         'template_path_stack' => array(
             'users' => __DIR__ . '/../view',
         ),
     ),
 );