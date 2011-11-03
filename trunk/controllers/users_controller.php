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
            // pr($usuario);
            // die(pr(sha1($this->Auth->data['User']['password'])));
            // var_dump($this->Auth->user());
            // die();
            if ($usuario && $usuario['User']['password'] == sha1($this->Auth->data['User']['password'])) {
                // die(pr($usuario));
                $this->Session->write('user', $usuario['User']['email']);
                $this->Session->write('numero', $usuario['User']['numero']);
                // pr($usuario['Role']['categoria']);
                // die();
                switch ($usuario['User']['categoria']) {
                    case 1:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        break;

                    // Categoria 2 eh estudante
                    case 2:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        $this->loadModel('Aluno');
                        $aluno_id = $this->Aluno->findByRegistro($usuario['User']['numero']);
                        if ($aluno_id) {
                            $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                        } else {
                            $this->loadModel('Alunonovo');
                            $aluno_id = $this->Alunonovo->findByRegistro($usuario['User']['numero']);
                            if ($aluno_id) {
                                $this->redirect('/Alunonovos/view/' . $aluno_id['Alunonovo']['id']);
                            } else {
                                $this->Session->setFlash('Estudante sem cadastro');
                                $this->redirect('/Alunonovos/add/');
                            }
                        }
                        break;

                    // Professor
                    case 3:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        // Verificar se cadastro do professor existe
                        $this->loadModel('Professor');
                        $professor = $this->Professor->findBySiape($usuario['User']['numero']);
                        // pr($professor);
                        // die("3");
                        if ($professor) {
                            $this->redirect('/Professors/view/' . $usuario['User']['numero']);
                        } else {
                            $this->Session->setFlash('Professor sem cadastrado: entrar em contato com a Coordenação de Estágio & Extensão');
                            $this->redirect('/users/login/');
                            // die("Professor não cadastrado");
                        }
                        // die("Fin de professor");
                        break;

                    // Supervisor
                    case 4:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        // Verifica se o cadastro do supervisor existe
                        $this->loadModel('Supervisor');
                        $supervisor = $this->Supervisor->findByCress($usuario['User']['numero']);
                        if ($supervisor) {
                            $this->redirect('/Supervisors/view/' . $usuario['User']['numero']);
                        } else {
                            $this->Session->setFlash('Supervisor sem cadastrado: entrar em contato com a Coordenação de Estágio & Extensão');
                            $this->redirect('/Supervisors/add/');
                        }
                        break;

                    default:
                        $this->Session->setFlash('Erro! Categoria de usuário desconhecida: ' . $this->Session->read('user'));
                        $this->redirect('/users/login/');
                        break;
                }
            } else {
                // die(pr($usuario));
                $this->Session->setFlash('Login/senha errado');
                $this->redirect('/users/login/');
            }
        }
    }

    function logout() {
        $this->Session->delete('user');
        $this->Session->delete('numero');
        $this->Session->setFlash('Até mais!');
        $this->redirect($this->Auth->logout());
    }

    function cadastro() {

        if (!empty($this->data)) {
            $this->data['User']['password'] = sha1($this->data['User']['password']);

            // die(pr($this->data));
            // Primeiro verifico se o email ja nao esta cadastrado
            $this->loadModel('Aros');
            $aluno_aros = $this->Aros->findByAlias($this->data['User']['email']);
            if ($aluno_aros) {
                $this->Session->setFlash("Email já cadastrado");
                $this->redirect("/Users/login/");
                die("Email já cadastrado");
            }

            // Agora, tenho que cadastrar como alunos, professores, etc
            switch ($this->data['User']['categoria']) {
                case 2:
                    $grupo = 'alunos';
                    $this->loadModel('Aluno');
                    $aluno = $this->Aluno->findByRegistro($this->data['User']['numero']);
                    if ($aluno) {
                        echo "Estudante estagiário ";
                    } else {
                        echo "Estudante novo? ";

                        $this->loadModel('Alunonovo');
                        $alunonovo = $this->Alunonovo->findByRegistro($this->data['User']['numero']);
                        if ($alunonovo) {
                            echo "Estudante novo ja cadastrado";
                        } else {
                            echo "Estudante novo não cadastrado";
                            // Para ir para alunonovos e poder voltar
                            /*
                              $this->Session->write('cadastro', $this->data['User']['email']);
                              $this->redirect('/Alunonovos/add/' . $this->data['User']['numero']);
                             */
                        }
                    }

                    $this->User->set($this->data);

                    if ($this->User->validates()) {
                        if ($this->User->save($this->data)) {
                            $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                            $this->Session->write('user', $this->data['User']['email']);
                            $this->Session->write('numero', $this->data['User']['numero']);
                        }
                    } else {
                        $errors = $this->User->invalidFields();
                        $this->Session->setFlash(implode(', ', $errors));
                        $this->redirect('/users/cadastro/');
                    }

                    /*
                      die();
                      $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                      $this->Session->write('user', $this->data['User']['email']);
                      $this->Session->write('numero', $this->data['User']['numero']);
                     */
                    break;


                case 3:
                    $grupo = 'professores';
                    $this->loadModel('Professor');
                    $professor = $this->Professor->findBySiape($this->data['User']['numero']);

                    // O professor ja tem que estar cadastrado
                    if ($professor) {
                        $this->User->save($this->data);
                        $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                        $this->Session->write('user', $this->data['User']['email']);
                        $this->Session->write('numero', $this->data['User']['numero']);
                    } else {
                        $this->Session->setFlash("Professor ainda não cadastrado: verifique o SIAPE");
                        $this->redirect('/Professors/index/');
                    }
                    break;

                case 4:
                    $grupo = 'supervisores';
                    $this->loadModel('Supervisor');
                    $supervisor = $this->Supervisor->findByCress($this->data['User']['numero']);

                    // O supervisor ja tem que estar cadastrado
                    if ($supervisor) {
                        $this->User->save($this->data);
                        $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                        $this->Session->write('user', $this->data['User']['email']);
                        $this->Session->write('numero', $this->data['User']['numero']);
                    } else {
                        $this->Session->setFlash("Supervisor ainda não cadastrado");
                        $this->redirect('/Supervisors/index/');
                    }
                    break;

                default:
                    $this->Session->setFlash('Error: Usuário não faz parte de nenhuma categoria');
                    $this->redirect('/users/cadastro/');
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
                    $this->redirect('/Professors/view/' . $professor_id['Professor']['id']);
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
