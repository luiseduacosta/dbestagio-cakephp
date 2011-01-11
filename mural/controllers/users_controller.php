<?php

class UsersController extends AppController {

    var $name = 'Users';
    var $helpers = array('Html', 'Form');

    function login() {
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Cadastro realizado');
            }
        }
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }

    function listausuarios() {
        $this->set('listausuarios', $this->User->find('all', array('fields' => array('id', 'username'), 'order' => 'id DESC')));
    }

}

?>
