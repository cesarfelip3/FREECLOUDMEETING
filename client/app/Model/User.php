<?php

App::uses('AppModel', 'Model');

class User extends AppModel {

    //public $name = "User";  

//    public function create ($data=array())
//    {
//        if (empty ($data)) {
//            return false;
//        }
//        
//        $this->create ($data);
//    }
    
    public function getUserByEmail ($email)
    {
        return $this->findByUserEmail ($email);
    }
    
    public function getUserByEmailAndPassword ($email, $password)
    {
        return $this->findByUserEmailAndUserPassword ($email, $password);        
    }
    
    public function getUserByActiveCode ($code)
    {
        
    }
    
    
}
