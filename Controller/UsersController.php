<?php

class UsersController extends AppController {

    public $name = 'Users';
    public $components = array('Auth');

    public function beforeFilter() {

        parent::beforeFilter();

        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
        } else {
            $this->Auth->allow('login', 'cadastro', 'contato');
        }
    }

    public function login() {

        $this->Session->delete('user');
        $this->Session->delete('numero');
        $this->Session->delete('id_categoria');
        $this->Session->delete('categoria');

        if (!empty($this->data)) {

            $usuario = $this->User->find('first', array(
                'conditions' => array('User.email' => $this->data['User']['email'])));

            // die();
            if ($usuario['User']['password'] == sha1($this->data['User']['password'])) {
                // die(pr($usuario));
                $this->Session->write('user', $usuario['User']['email']);
                $this->Session->write('numero', $usuario['User']['numero']);
                $this->Session->write('id_categoria', $usuario['Role']['id']);
                $this->Session->write('categoria', $usuario['Role']['categoria']);
                // die();
                switch ($usuario['User']['categoria']) {
                    case 1: // Administrador
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        $this->redirect('/estagiarios/index/');
                        break;

                    // Categoria 2 eh estudante
                    case 2:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        $this->loadModel('Aluno');
                        $aluno_id = $this->Aluno->findByRegistro($usuario['User']['numero']);
                        if ($aluno_id) {
                            $this->Session->write('menu_aluno', 'estagiario');
                            $this->Session->write('menu_id_aluno', $aluno_id['Aluno']['id']);
                            $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                        } else {
                            $this->loadModel('Alunonovo');
                            $aluno_id = $this->Alunonovo->findByRegistro($usuario['User']['numero']);
                            if ($aluno_id) {
                                $this->Session->write('menu_aluno', 'alunonovo');
                                $this->Session->write('menu_id_aluno', $aluno_id['Alunonovo']['id']);
                                $this->redirect('/Alunonovos/view/' . $aluno_id['Alunonovo']['id']);
                            } else {
                                $this->Session->write('menu_aluno', 'semcadastro');
                                $this->Session->write('menu_id_aluno', 0);
                                $this->Session->setFlash('Estudante novo sem cadastro');
                                // Tem que impedir que estudante nao cadastro possa continuar
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
                        pr($professor);
                        // die("3");
                        if ($professor) {
                            $this->redirect('/Professors/view/' . $professor['Professor']['id']);
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
                            $this->Session->write("menu_id_supervisor", $supervisor['Supervisor']['id']);
                            $this->redirect('/Supervisors/view/' . $supervisor['Supervisor']['id']);
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
                $this->Session->setFlash('Login/senha errado ou usuário não cadastrado');
                $this->redirect('/users/login/');
            }
        }
    }

    public function logout() {
        $this->Session->delete('user');
        $this->Session->delete('numero');
        $this->Session->delete('categoria');
        $this->Session->delete('menu_aluno');
        $this->Session->delete('menu_id_aluno');
        $this->Session->setFlash('Até mais!');
        $this->redirect($this->Auth->logout());
    }

    public function cadastro() {

        if (!empty($this->data)) {

            if ($this->data['User']['password']) {
                $this->request->data['User']['password'] = SHA1($this->data['User']['password']);
            }

            /*
             * Para recuperar a senha faz um novo cadastro
             */
            $usuariocadastrado = $this->User->find('first', array(
                'conditions' => array('and' => array('User.categoria' => $this->data['User']['categoria'], 'User.email' => $this->data['User']['email'], 'User.numero' => $this->data['User']['numero']))
            ));

            // pr($usuariocadastrado);
            // die();
            /*
             * Se está recuperando a senha
             * excluo o registro do usuer e do aro
             */
            if ($usuariocadastrado) {
                echo "Recuperação de senha de usuário já cadastrado";
                // pr($usuariocadastrado);
                // pr($usuariocadastrado['User']['id']);
                if ($this->User->delete($usuariocadastrado['User']['id'])) {
                    echo "Usuario excluido";
                    // die("delete user");
                }
                // die("delete user");
            }
            // die("usuariocadastrado");
            // Primeiro verifico se o registro ja nao esta cadastrado no user
            $numero = $this->User->findByNumero($this->data['User']['numero']);
            // pr($numero);
            // die();

            if ($numero) {
                $numero_user = $this->User->findByNumero($this->data['User']['numero']);
                // pr($email_user);
                // die();
                $this->Session->setFlash("Número (DRE, CRESS ou SIAPE) já cadastrado");
                $this->redirect("/Users/login/");
                die("Numero já cadastrado");
            }
            // die("Numero já cadastrado");
            // Segundo verifico se o email ja nao esta cadastrado no user
            $email = $this->User->findByEmail($this->data['User']['email']);
            // pr($email);
            // die();

            if ($email) {
                $email_user = $this->User->findByEmail($this->data['User']['email']);
                // pr($email_user);
                // die();
                $this->Session->setFlash("Email já cadastrado");
                $this->redirect("/Users/login/");
                die("Email já cadastrado");
            }
            // die("Email já cadastrado");
            // Agora, tenho que cadastrar como alunos, professores, etc
            switch ($this->data['User']['categoria']) {
                case 2:
                    $grupo = 'alunos';
                    $this->loadModel('Aluno');
                    $aluno = $this->Aluno->findByRegistro($this->data['User']['numero']);
                    // pr($aluno);
                    // die(pr($this->data['User']['numero']));
                    if ($aluno) {
                        $situacao = 1; // Estudante estagiário
                        $nome = $aluno['Aluno']['nome'];
                        $this->Session->write('menu_aluno', 'estagiario');
                        $this->Session->write('menu_id_aluno', $aluno['Aluno']['id']);
                        // echo "Estudante estagiário ";
                    } else {
                        // echo "Estudante novo? ";
                        // die("Estudante novo?");
                        $this->loadModel('Alunonovo');
                        $alunonovo = $this->Alunonovo->findByRegistro($this->data['User']['numero']);
                        // die(pr($alunonovo));
                        if ($alunonovo) {
                            $situacao = 2; // Estudante novo que busca estágio
                            $nome = $aluno['Alunonovo']['nome'];
                            $this->Session->write('menu_aluno', 'alunonovo');
                            $this->Session->write('menu_id_aluno', $alunonovo['Alunonovo']['id']);
                            echo "Estudante novo ja cadastrado";
                        } else {
                            // echo "Estudante novo não cadastrado";
                            // die("Estudante novo não cadastrado");
                            $situacao = 3; // Estudante novo
                            $this->Session->write('menu_aluno', 'semcadastro');
                            // Para ir para alunonovos e poder voltar
                            $this->Session->write('cadastro', $this->data['User']['email']);
                        }
                    }

                    $this->User->set($this->data);

                    if ($this->User->validates()) {
                        if ($this->User->save($this->data)) {
                            $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                            $this->Session->write('categoria', 'estudante');
                            $this->Session->write('id_categoria', '2');
                            $this->Session->write('user', $this->data['User']['email']);
                            $this->Session->write('numero', $this->data['User']['numero']);
                        }
                    } else {
                        // $errors = $this->User->invalidFields();
                        // pr($errors);
                        // $this->Session->setFlash(implode(', ', $errors));
                        $this->Session->setFlash('Não foi possível completar seu cadastro.');
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
                        // $this->redirect('/Supervisors/view/' . $supervisor['Supervisor']['id']);
                    } else {
                        $this->Session->setFlash("Supervisor ainda não cadastrado. Somente podem criar conta os supervisores com CRESS registrados na Coordenação de Estágio e Extensão");
                        $this->redirect('/users/login/');
                    }
                    break;

                default:
                    $this->Session->setFlash('Error: Usuário não faz parte de nenhuma categoria');
                    $this->redirect('/users/cadastro/');
                    break;
            }

            // Redirecionamentos
            switch ($this->data['User']['categoria']) {
                // Encaminhar para aluno ou alunonovo view
                case 2: // Aluno
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
                        } else {
                            $this->redirect('/Alunonovos/add/');
                        }
                    }
                    break;

                case 3: // Professor
                    $this->loadModel('Professor');
                    $professor_id = $this->Professor->findBySiape($this->data['User']['numero']);
                    $this->redirect('/Professors/view/' . $professor_id['Professor']['id']);
                    break;

                case 4: // Supervisor
                    $this->loadModel('Supervisor');
                    $supervisor_id = $this->Supervisor->findByCress($this->data['User']['numero']);
                    $this->Session->write("menu_id_supervisor", $supervisor['Supervisor']['id']);
                    $this->redirect('/Supervisors/view/' . $supervisor_id['Supervisor']['id']);
                    break;
            }

            $this->redirect('/murals/index/');
        } else {
            // $this->request->data['User']['password'] = '';
            // $this->Session->setFlash('Não foi possível completar o cadastramento');
        }
    }

    public function contato() {

        // echo "Enviar email para estagio@ess.ufrj.br";
    }

    public function index() {

        $usuarios = $this->User->find('all', array(
            'order' => array('User.email')
        ));
        // pr($usuarios);

        $this->paginate = array(
            'User' => array(
                'limit' => 20,
                'order' => array('User.email'))
        );

        $this->set('usuarios', $this->paginate('User'));
    }

    public function listausuarios() {

        // $this->loadModel('User');
        $usuarios = $this->User->find('all');

        $this->loadModel('Aluno');
        $this->loadModel('Alunonovo');
        $this->loadModel('Professor');
        $this->loadModel('Supervisor');
        $i = 1;
        foreach ($usuarios as $cadausuario) {
            // pr($cadausuario);
            $estudante = NULL;
            $nome = NULL;
            $aluno_id = NULL;
            $aluno_tipo = NULL;
            switch ($cadausuario['User']['categoria']) {
                case 1:
                    $nome = 'Administrador';
                    $aluno_tipo = 5;
                    break;
                case 2:
                    // Busco entre os estudantes em estágio
                    $estudante = $this->Aluno->find('first', array(
                        'conditions' => 'Aluno.registro=' . $cadausuario['User']['numero']));

                    if ($estudante) {
                        $nome = $estudante['Aluno']['nome'];
                        $aluno_id = $estudante['Aluno']['id'];
                        $aluno_tipo = 0; // Aluno estagiario
                    } else {
                        // Se não está entre os estudantes em estágio busco entre os novos
                        // $estudantenovo = NULL;
                        $estudantenovo = $this->Alunonovo->find('first', array(
                            'conditions' => 'Alunonovo.registro=' . $cadausuario['User']['numero']));
                        if ($estudantenovo) {
                            $nome = $estudantenovo['Alunonovo']['nome'];
                            $aluno_id = $estudantenovo['Alunonovo']['id'];
                            $aluno_tipo = 1; // Aluno novo
                        } else {
                            // Se não está entre os novos então é um usuario nao cadastrado    
                            $nome = "Usuário estudante sem cadastro";
                            $aluno_id = NULL;
                            $aluno_tipo = 2; // Usuario estudante nao cadastrado                            
                        }
                    }
                    break;
                case 3:
                    $professor = $this->Professor->find('first', array(
                        'conditions' => 'Professor.siape=' . $cadausuario['User']['numero']));
                    if ($professor) {
                        $nome = $professor['Professor']['nome'];
                    } else {
                        $nome = 'Professor não cadastrado!!';
                    }
                    $aluno_id = $professor['Professor']['id'];
                    $aluno_tipo = 3;
                    break;
                case 4:
                    $supervisor = $this->Supervisor->find('first', array(
                        'conditions' => 'Supervisor.cress=' . $cadausuario['User']['numero']));
                    if ($supervisor) {
                        $nome = $supervisor['Supervisor']['nome'];
                    } else {
                        $nome = "Supervisor não cadastrado!!";
                    }
                    $aluno_id = $supervisor['Supervisor']['id'];
                    $aluno_tipo = 4;
                    break;
                default:
                    $nome = 'Sem categoria!!';
                    $aluno_id = NULL;
                    $aluno_tipo = 5;
                    break;
            }
            // echo "Indice " . $i . "<br>";
            $todos[$i]['id'] = $cadausuario['User']['id'];
            $todos[$i]['aluno_tipo'] = $aluno_tipo;
            $todos[$i]['aluno_id'] = $aluno_id;
            $todos[$i]['numero'] = $cadausuario['User']['numero'];
            $todos[$i]['nome'] = $nome;
            $todos[$i]['email'] = $cadausuario['User']['email'];
            $todos[$i]['categoria'] = $cadausuario['Role']['categoria'];
            $i++;
        }
        // pr($todos);
        $this->set('listausuarios', $todos);
        // $this->set('listausuarios', $this->User->find('all'));
    }

}

?>
