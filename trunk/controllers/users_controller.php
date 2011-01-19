<?php

class UsersController extends AppController {

    var $name = 'Users';

    function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allowedActions = array('*');
    }

    function login() {

        // $this->Session->delete('user');

        if (!empty($this->data)) {

            $usuario = $this->User->find('first', array(
                        'conditions' => array('User.email' => $this->data['User']['email'])));
            // pr($usuario);
            // die(pr(sha1($this->Auth->data['User']['password'])));
            if ($usuario && $usuario['User']['password'] == sha1($this->Auth->data['User']['password'])) {

                $this->Session->write('user', $usuario['User']['email']);
                $this->Session->setFlash('Bem-vindo: ' . $this->Session->read('user'));
                $this->redirect('/murals/index/');
                exit;
            } else {
                $this->Session->setFlash('Usuário não cadastrado');
                $this->redirect('/users/cadastro/');
            }
        }
    }

    function logout() {
        $this->Session->delete('user');
        $this->redirect($this->Auth->logout());
    }

    function listausuarios() {
        $this->set('listausuarios', $this->User->find('all', array('fields' => array('id', 'username'), 'order' => 'id DESC')));
    }

    function cadastro() {

        if (!empty($this->data)) {
            $this->data['User']['password'] = sha1($this->data['User']['password']);
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                $this->Session->write('user', $this->data['User']['nome']);

                // Tenho que cadastrar como alunos, professores, etc
                $parent = $this->Acl->Aro->findByAlias('alunos'); // alunos professores supervisores
                $aro = new Aro();
                $aro->create();
                $aro->save(array(
                    'alias' => $this->data['User']['email'],
                    'model' => 'User',
                    'foreign_key' => $this->User->id,
                    'parent_id' => $parent['Aro']['id'])
                );
                $this->Acl->Aro->save();

                $this->redirect('/Murals/index/');
            } else {
                $this->data['User']['password'] = '';
                $this->Session->setFlash('Não foi possível completar o cadastramento');
            }
        }
    }

}

?>
