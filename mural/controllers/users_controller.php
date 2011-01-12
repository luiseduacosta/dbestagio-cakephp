<?php

class UsersController extends AppController {

	var $name = 'Users';

	function login() {

		$this->Session->delete('user');
		
		if (!empty($this->data)) {
		
			$usuario = $this->User->find('first', array(
        		'conditions' => array('User.nome' => $this->data['User']['nome'])));
			
			if ($usuario && $usuario['User']['password'] == md5($this->data['User']['password'])) { 

				
				
				$this->Session->write('user', $usuario['User']['nome']);
				$this->Session->setFlash('Bem-vindo: login realizado');
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
			$this->data['User']['password'] = md5($this->data['User']['password']);
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('Bem-vindo! Cadastro realizado');
				$this->Session->write('user', $this->data['User']['nome']);
				$this->redirect('/Estagiarios/index/');
			} else {
				$this->data['User']['password'] = '';
				$this->Session->setFlash('Não foi possível completar o cadastramento');
			}
		}
	}

}

?>
