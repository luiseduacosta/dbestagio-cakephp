<?php

class UsersController extends AppController {

    var $name = 'Users';

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('*');
    }

    function login() {

        if (!empty($this->data)) {

            $usuario = $this->User->find('first', array(
                        'conditions' => array('User.email' => $this->data['User']['email'])));
            // die(pr($usuario));
            // die(pr(sha1($this->Auth->data['User']['password'])));
            if ($usuario && $usuario['User']['password'] == sha1($this->Auth->data['User']['password'])) {
                // die(pr($usuario));
                $this->Session->write('user', $usuario['User']['email']);
                $this->Session->write('numero', $usuario['User']['numero']);
                $this->Session->setFlash('Bem-vindo: ' . $this->Session->read('user'));
                if ($usuario['User']['categoria'] == '1') {
                    // pr($usuario['User']['numero']);
                    // pr($usuario['User']['categoria']);
                    $this->loadModel('Aluno');
                    $aluno_id = $this->Aluno->findByRegistro($usuario['User']['numero']);
                    if ($aluno_id) {
                        $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                    } else {
                        $this->loadModel('Alunonovo');
                        $aluno_id = $this->Alunonovo->findByRegistro($usuario['User']['numero']);
                        if ($aluno_id) {
                            $this->redirect('/Alunonovos/view/' . $aluno_id['Alunonovo']['id']);
                        }
                    }
                } else {
                    $this->redirect('/murals/index/');
                    exit;
                }
            } else {
                // die(pr($usuario));
                $this->Session->setFlash('Usuário não cadastrado');
                $this->redirect('/users/cadastro/');
            }
        }
    }

    function logout() {
        $this->Session->delete('user');
        $this->Session->delete('numero');
        $this->Session->setFlash('Até mais!');
        $this->redirect($this->Auth->logout());
    }

    function listausuarios() {

        $this->set('listausuarios', $this->User->find('all', array('fields' => array('id', 'categoria', 'numero', 'email'), 'order' => 'id DESC')));
    }

    function cadastro() {

        if (!empty($this->data)) {
            $this->data['User']['password'] = sha1($this->data['User']['password']);

            // die(pr($this->data));
            // Tenho que cadastrar como alunos, professores, etc
            switch ($this->data['User']['categoria']) {
                case 1:
                    $grupo = 'alunos';
                    $this->loadModel('Aluno');
                    $aluno = $this->Aluno->findByRegistro($this->data['User']['numero']);
                    if ($aluno) {
                        echo "Estudante estagiário";
                    } else {
                        echo "Estudante novo?";
                        $this->loadModel('Alunonovo');
                        $alunonovo = $this->Alunonovo->findByRegistro($this->data['User']['numero']);
                        if ($alunonovo) {
                            echo "Estudante novo";
                        } else {
                            echo "Estudante não cadastrado";
                            // Para ir para alunonovos e poder voltar
                            $this->Session->write('cadastro', $this->data['User']['email']);
                            $this->redirect('/Alunonovos/add/' . $this->data['User']['numero']);
                        }
                    }

                    $this->User->save($this->data);
                    $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                    $this->Session->write('user', $this->data['User']['email']);
                    $this->Session->write('numero', $this->data['User']['numero']);

                    break;

                case 2:
                    $grupo = 'professores';
                    $this->loadModel('Professor');
                    $professor = $this->Professor->findBySiape($this->data['User']['numero']);

                    if ($professor) {
                        $this->User->save($this->data);
                        $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                        $this->Session->write('user', $this->data['User']['email']);
                        $this->Session->write('numero', $this->data['User']['numero']);
                    } else {
                        $this->Session->setFlash("Professor ainda não cadastrado: verifique o SIAPE");
                        // $this->redirect('/Users/login/');
                    }
                    
                    break;

                case 3:
                    $grupo = 'supervisores';
                    $this->loadModel('Supervisor');
                    $supervisor = $this->Supervisor->findByCress($this->data['User']['numero']);

                    if ($supervisor) {
                       $this->User->save($this->data);
                        $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                        $this->Session->write('user', $this->data['User']['email']);
                        $this->Session->write('numero', $this->data['User']['numero']);
                    } else {
                        $this->Session->setFlash('Supervisor ainda não cadastrado');
                        // $this->redirect('/Supervisors/add/');
                    }

                    break;
            }

            $parent = $this->Acl->Aro->findByAlias($grupo); // alunos professores supervisores
            $aro = new Aro();
            $aro->create();
            $aro->save(array(
                'alias' => $this->data['User']['email'],
                'model' => 'User',
                'foreign_key' => $this->User->id,
                'parent_id' => $parent['Aro']['id'])
            );
            $this->Acl->Aro->save();

            // Redirecionamentos
            switch ($this->data['User']['categoria']) {
                // Encaminhar para aluno ou alunonovo view
                case 1: // Aluno
                    // pr($usuario['User']['numero']);
                    // pr($usuario['User']['categoria']);
                    $this->loadModel('Aluno');
                    $aluno_id = $this->Aluno->findByRegistro($this->data['User']['numero']);
                    if ($aluno_id) {
                        $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                    } else {
                        $this->loadModel('Alunonovo');
                        $aluno_id = $this->Alunonovo->findByRegistro($this->data['User']['numero']);
                        if ($aluno_id) {
                            $this->redirect('/Alunonovos/view/' . $aluno_id['Alunonovo']['id']);
                        }
                    }
                    break;

                case 2: // Professor
                    $this->loadModel('Professor');
                    $professor_id = $this->Professor->findBySiape($this->data['User']['numero']);
                    // $this->redirect('/Professors/view/' . $professor_id['Professor']['id']);
                    break;

                case 3: // Supervisor
                    $this->loadModel('Supervisor');
                    $supervisor_id = $this->Supervisor->findByCress($this->data['User']['numero']);
                    $this->redirect('/Supervisors/view/' . $supervisor_id['Supervisor']['id']);
                    break;
            }

            $this->redirect('/murals/index/');
        } else {
            $this->data['User']['password'] = '';
            // $this->Session->setFlash('Não foi possível completar o cadastramento');
        }
    }

}

?>
