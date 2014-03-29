<?php

App::uses('AppController', 'Controller');

class IndexController extends AppController {

    //public $name = 'Pages';
    //public $uses = array();

    public function index ()
    {
        $this->layout = false;
        $this->redirect("/panel/");
        exit;
    }

}
