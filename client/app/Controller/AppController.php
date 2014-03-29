<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    const _siteurl = "http://cloudconferenceroom.com/client";
    const _authentication_session = "user_authentication";
    protected $_identity = null;
    
//    public $components = array(
//        'Session',
//        'Auth' => array(
//            'loginAction' => array(
//                'controller' => 'auth',
//                'action' => 'signin',
//                'plugin' => 'users'
//            ),
//            'authError' => 'Did you really think you are allowed to see that?',
//            'authenticate' => array(
//                'Form' => array(
//                    'User' => 'users',
//                    'fields' => array('username' => 'user_email', 
//                        'password'=>'user_password'),
//                    'scope' => array('User.user_active' => 1)
//                )
//            ),
//            'loginRedirect' => array('controller' => 'panel', 'action' => 'index'),
//            'logoutRedirect' => array('controller' => 'auth', 'action' => 'signin')
//        )
//    );
    
    public function beforeFilter ()
    {
        $this->_identity = $this->Session->read (self::_authentication_session);
    }

    protected function debug ($data, $exit = false) 
    {
        print_r ("<textarea style='width:300px;height:200px;'>");
        print_r (var_export ($data, true));
        print_r ("</textarea>");
        if ($exit) {
            exit;
        }
    }
}
