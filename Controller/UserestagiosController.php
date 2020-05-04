<?php

class UserestagiosController extends AppController {

    public $name = 'Userestagios';
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

        // pr($this->data);
        // die();
        if (!empty($this->data)) {

            $usuario = $this->Userestagio->find('first', array(
                'conditions' => array('Userestagio.email' => $this->data['Userestagio']['email'])));

            // pr($usuario);
            // die();
            if ($usuario['Userestagio']['password'] == sha1($this->data['Userestagio']['password'])) {
                // die(pr($usuario));
                $this->Session->write('user', $usuario['Userestagio']['email']);
                $this->Session->write('numero', $usuario['Userestagio']['numero']);
                $this->Session->write('id_categoria', $usuario['Role']['id']);
                $this->Session->write('categoria', $usuario['Role']['categoria']);
                // die();
                switch ($usuario['Userestagio']['categoria']) {
                    case 1: // Administrador
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        $this->redirect('/Estagiarios/index/');
                        break;

                    // Categoria 2 eh estudante
                    case 2:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        $this->loadModel('Aluno');
                        $aluno_id = $this->Aluno->findByRegistro($usuario['Userestagio']['numero']);
                        if ($aluno_id) {
                            $this->Session->write('menu_aluno', 'estagiario');
                            $this->Session->write('menu_id_aluno', $aluno_id['Aluno']['id']);
                            $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                        } else {
                            $this->loadModel('Estudante');
                            $aluno_id = $this->Estudante->findByRegistro($usuario['Userestagio']['numero']);
                            if ($aluno_id) {
                                $this->Session->write('menu_aluno', 'alunonovo');
                                $this->Session->write('menu_id_aluno', $aluno_id['Estudante']['id']);
                                $this->redirect('/Estudantes/view/' . $aluno_id['Estudante']['id']);
                            } else {
                                $this->Session->write('menu_aluno', 'semcadastro');
                                $this->Session->write('menu_id_aluno', 0);
                                $this->Session->setFlash('Estudante novo sem cadastro');
                                // Tem que impedir que estudante nao cadastro possa continuar
                                $this->redirect('/Estudantes/add/');
                            }
                        }
                        break;

                    // Professor
                    case 3:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        // Verificar se cadastro do professor existe
                        $this->loadModel('Professor');
                        $professor = $this->Professor->findBySiape($usuario['Userestagio']['numero']);
                        pr($professor);
                        // die("3");
                        if ($professor) {
                            $this->redirect('/Professors/view/' . $professor['Professor']['id']);
                        } else {
                            $this->Session->setFlash('Professor sem cadastrado: entrar em contato com a Coordenação de Estágio & Extensão');
                            $this->redirect('/Userestagios/login/');
                            // die("Professor não cadastrado");
                        }
                        // die("Fin de professor");
                        break;

                    // Supervisor
                    case 4:
                        $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        // Verifica se o cadastro do supervisor existe
                        $this->loadModel('Supervisor');
                        $supervisor = $this->Supervisor->findByCress($usuario['Userestagio']['numero']);
                        if ($supervisor) {
                            $this->Session->write("menu_supervisor_id", $supervisor['Supervisor']['id']);
                            $this->redirect('/Supervisors/view/' . $supervisor['Supervisor']['id']);
                        } else {
                            $this->Session->setFlash('Supervisor sem cadastrado: entrar em contato com a Coordenação de Estágio & Extensão');
                            $this->redirect('/Supervisors/add/');
                        }
                        break;

                    default:
                        $this->Session->setFlash('Erro! Categoria de usuário desconhecida: ' . $this->Session->read('user'));
                        $this->redirect('/Userestagios/login/');
                        break;
                }
            } else {
                // die(pr($usuario));
                $this->Session->setFlash('Login/senha errado ou usuário não cadastrado');
                $this->redirect('/Userestagios/login/');
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
        // die('logout');
        $this->redirect('/Userestagios/login');
    }

    public function cadastro() {

        // pr($this->data);
        if (!empty($this->data)) {
            // pr($this->data);

            /*
             * Para recuperar a senha faz um novo cadastro
             */
            $usuariocadastrado = $this->User->find('first', array(
                'conditions' => array(
                    'Userestagio.categoria' => $this->data['Userestagio']['categoria'],
                    'Userestagio.email' => $this->data['Userestagio']['email'],
                    'Userestagio.numero' => $this->data['Userestagio']['numero'])
                    )
            );

            /*
             * Se está recuperando a senha
             * excluo o registro do usuer e do aro
             */
            if ($usuariocadastrado) {
                echo "Recuperação de senha de usuário já cadastrado";
                // pr($usuariocadastrado);
                // pr($usuariocadastrado['User']['id']);
                if ($this->Userestagio->delete($usuariocadastrado['Userestagio']['id'])) {
                    echo "Usuario excluido";
                    // die("delete user");
                }
                // die("delete user");
            }
            // die("usuariocadastrado");
            // Primeiro verifico se o registro ja nao esta cadastrado no user
            $numero = $this->Userestagio->findByNumero($this->data['Userestagio']['numero']);
            // pr($numero);
            // die('numero');

            if ($numero) {
                // $numero_user = $this->User->findByNumero($this->data['User']['numero']);
                // pr($email_user);
                // die();
                $this->Session->setFlash("Número (DRE, CRESS ou SIAPE) já cadastrado");
                $this->redirect("/Userestagios/login/");
                die("Numero já cadastrado");
            }
            // die("Numero já cadastrado");
            // Segundo verifico se o email ja nao esta cadastrado no user
            $email = $this->Userestagio->findByEmail($this->data['Userestagio']['email']);
            // pr($email);
            // die('email');

            if ($email) {
                // $email_user = $this->User->findByEmail($this->data['User']['email']);
                // pr($email_user);
                // die();
                $this->Session->setFlash("Email já cadastrado");
                $this->redirect("/Userestagios/login/");
                die("Email já cadastrado");
            }
            // die("Email já cadastrado");
            // Agora, tenho que cadastrar como alunos, professores, etc
            switch ($this->data['Userestagio']['categoria']) {
                case 2:
                    $grupo = 'alunos';
                    $this->loadModel('Aluno');
                    $aluno = $this->Aluno->findByRegistro($this->data['Userestagio']['numero']);
                    // pr($aluno);
                    //die(pr($this->data['User']['numero']));
                    if ($aluno) {
                        $situacao = 1; // Estudante estagiário
                        $nome = ucwords($aluno['Aluno']['nome']);
                        $this->Session->write('menu_aluno', 'estagiario');
                        $this->Session->write('menu_id_aluno', $aluno['Aluno']['id']);
                        // echo "Estudante estagiário ";
                    } else {
                        // echo "Estudante novo? ";
                        // die("Estudante novo?");
                        $this->loadModel('Estudante');
                        $alunonovo = $this->Estudante->findByRegistro($this->data['Userestagio']['numero']);
                        // die(pr($alunonovo));
                        if ($alunonovo) {
                            $situacao = 2; // Estudante novo que busca estágio
                            $nome = ucwords($aluno['Estudante']['nome']);
                            $this->Session->write('menu_aluno', 'alunonovo');
                            $this->Session->write('menu_id_aluno', $alunonovo['Estudante']['id']);
                            echo "Estudante novo ja cadastrado";
                        } else {
                            // echo "Estudante novo não cadastrado";
                            // die("Estudante novo não cadastrado");
                            $situacao = 3; // Estudante novo
                            $this->Session->write('menu_aluno', 'semcadastro');
                            // Para ir para estudante e poder voltar
                            $this->Session->write('cadastro', strtolower($this->data['Userestagio']['email']));
                        }
                    }

                    $this->User->set($this->data);

                    if ($this->User->validates()) {
                        if ($this->User->save($this->data)) {
                            $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                            $this->Session->write('categoria', 'estudante');
                            $this->Session->write('id_categoria', '2');
                            $this->Session->write('user', strtolower($this->data['Userestagio']['email']));
                            $this->Session->write('numero', $this->data['Userestagio']['numero']);
                        }
                    } else {
                        // $errors = $this->User->invalidFields();
                        // pr($errors);
                        // $this->Session->setFlash(implode(', ', $errors));
                        $this->Session->setFlash('Não foi possível completar seu cadastro.');
                        $this->redirect('/Userestagios/cadastro/');
                    }

                    break;

                case 3:
                    $grupo = 'professores';
                    $this->loadModel('Professor');
                    $professor = $this->Professor->findBySiape($this->data['Userestagio']['numero']);

                    // O professor ja tem que estar cadastrado
                    if ($professor) {
                        $this->User->save($this->data);
                        $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                        $this->Session->write('user', strtolower($this->data['Userestagio']['email']));
                        $this->Session->write('numero', $this->data['Userestagio']['numero']);
                    } else {
                        $this->Session->setFlash("Professor ainda não cadastrado: verifique o SIAPE");
                        $this->redirect('/Professors/index/');
                    }
                    break;

                case 4:
                    $grupo = 'supervisores';
                    $this->loadModel('Supervisor');
                    $supervisor = $this->Supervisor->findByCress($this->data['Userestagio']['numero']);

                    // O supervisor ja tem que estar cadastrado
                    if ($supervisor) {
                        $this->User->save($this->data);
                        $this->Session->setFlash('Bem-vindo! Cadastro realizado');
                        $this->Session->write('user', strtolower($this->data['Userestagio']['email']));
                        $this->Session->write('numero', $this->data['Userestagio']['numero']);
                        // $this->redirect('/Supervisors/view/' . $supervisor['Supervisor']['id']);
                    } else {
                        $this->Session->setFlash("Supervisor ainda não cadastrado. Somente podem criar conta os supervisores com CRESS registrados na Coordenação de Estágio e Extensão");
                        $this->redirect('/Userestagios/login/');
                    }
                    break;

                default:
                    $this->Session->setFlash('Error: Usuário não faz parte de nenhuma categoria');
                    $this->redirect('/Userestagios/cadastro/');
                    break;
            }

            // Redirecionamentos
            switch ($this->data['Userestagio']['categoria']) {
                // Encaminhar para aluno ou alunonovo view
                case 2: // Aluno
                    // pr($usuario['User']['numero']);
                    // pr($usuario['User']['categoria']);
                    $this->loadModel('Aluno');
                    $aluno_id = $this->Aluno->findByRegistro($this->data['Userestagio']['numero']);
                    if ($aluno_id) {
                        $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                    } else {
                        $this->loadModel('Estudante');
                        $aluno_id = $this->Estudante->findByRegistro($this->data['Userestagio']['numero']);
                        if ($aluno_id) {
                            $this->redirect('/Estudantes/view/' . $aluno_id['Estudante']['id']);
                        } else {
                            $this->redirect('/Estudantes/add/');
                        }
                    }
                    break;

                case 3: // Professor
                    $this->loadModel('Professor');
                    $professor_id = $this->Professor->findBySiape($this->data['Userestagio']['numero']);
                    $this->redirect('/Professors/view/' . $professor_id['Professor']['id']);
                    break;

                case 4: // Supervisor
                    $this->loadModel('Supervisor');
                    $supervisor_id = $this->Supervisor->findByCress($this->data['Userestagio']['numero']);
                    $this->Session->write("menu_supervisor_id", $supervisor['Supervisor']['id']);
                    $this->redirect('/Supervisors/view/' . $supervisor_id['Supervisor']['id']);
                    break;
            }

            $this->redirect('/Murals/index/');
        } else {
            // $this->request->data['User']['password'] = '';
            // $this->Session->setFlash('Não foi possível completar o cadastramento');
        }
    }

    public function contato() {

        // echo "Enviar email para estagio@ess.ufrj.br";
    }

    public function index() {

        $this->paginate = array(
            'Userestagio' => array(
                'limit' => 20,
                'order' => array('Userestagio.email'))
        );

        $this->set('usuarios', $this->paginate('Userestagio'));
    }

    public function listausuarios() {

        $parametros = $this->params['named'];
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'nome';
        $direcao = isset($parametros['direcao']) ? $parametros['direcao'] : 'ascendente';
        $linhas = isset($parametros['linhas']) ? $parametros['linhas'] : 15;
        $pagina = isset($parametros['pagina']) ? $parametros['pagina'] : 1;
        $q_paginas = isset($parametros['q_paginas']) ? $parametros['q_paginas'] : NULL;
        // pr('param: ' . $pagina);
        // die();

        $usuarios = $this->Userestagio->find('all');

        $this->loadModel('Aluno');
        $this->loadModel('Estudante');
        $this->loadModel('Professor');
        $this->loadModel('Supervisor');
        $i = 1;
        foreach ($usuarios as $cadausuario) {
            // pr($cadausuario);
            $estudante = NULL;
            $nome = NULL;
            $aluno_id = NULL;
            $aluno_tipo = NULL;
            switch ($cadausuario['Userestagio']['categoria']) {
                case 1:
                    $nome = 'Administrador';
                    $aluno_tipo = 5;
                    break;
                case 2:
                    // Busco entre os estudantes em estágio
                    $estudante = $this->Aluno->find('first', [
                        'conditions' => ['Aluno.registro' => [$cadausuario['Userestagio']['numero']]]]);

                    // pr($estudante);
                    if ($estudante) {
                        $nome = $estudante['Aluno']['nome'];
                        $aluno_id = $estudante['Aluno']['id'];
                        $aluno_tipo = 0; // Aluno estagiario
                    } else {
                        // Se não está entre os estudantes em estágio busco entre os novos
                        // $estudantenovo = NULL;
                        $estudantenovo = $this->Estudante->find('first', [
                            'conditions' => ['Estudante.registro' => $cadausuario['Userestagio']['numero']]]);

                        if ($estudantenovo) {
                            $nome = $estudantenovo['Estudante']['nome'];
                            $aluno_id = $estudantenovo['Estudante']['id'];
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
                        'conditions' => 'Professor.siape=' . $cadausuario['Userestagio']['numero']));
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
                        'conditions' => 'Supervisor.cress=' . $cadausuario['Userestagio']['numero']));
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
            $todos[$i]['id'] = $cadausuario['Userestagio']['id'];
            $todos[$i]['aluno_tipo'] = $aluno_tipo;
            $todos[$i]['aluno_id'] = $aluno_id;
            $todos[$i]['numero'] = $cadausuario['Userestagio']['numero'];
            $todos[$i]['nome'] = $nome;
            $todos[$i]['email'] = $cadausuario['Userestagio']['email'];
            $todos[$i]['categoria'] = $cadausuario['Role']['categoria'];
            $criterio[$i] = $todos[$i][$ordem];
            $i++;
        }
        // pr($criterio);
        // pr($direcao);
        if ($direcao):
            if ($direcao == 'ascendente'):
                array_multisort($criterio, SORT_ASC, $todos);
                $direcao = 'descendente';
            elseif ($direcao == 'descendente'):
                array_multisort($criterio, SORT_DESC, $todos);
                $direcao = 'ascendente';
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $todos);
            endif;
        endif;
        // pr($direcao);

        if ($linhas == 0) { // Sem paginação
            $q_paginas = 1;
        } else {
            $registros = sizeof($todos);
            // echo "Calculo quantos registros: " . $registros . "<br>";
            $q_paginas = $registros / $linhas;
            // echo "Quantas páginas " . ceil($q_paginas) . "<br>";
            // die();
            $c_pagina[] = NULL;
            $pagina_inicial = 0;
            $pagina_final = 0;
            for ($i = 0; $i < ceil($q_paginas); $i++):
                $pagina_inicial = $pagina_inicial + $pagina_final;
                $pagina_final = $linhas;
                $c_pagina[] = array_slice($todos, $pagina_inicial, $pagina_final);
            endfor;
        }
        // pr($c_pagina[10]);
        // pr($todos);
        if ($linhas == 0):
            $this->set('listausuarios', $todos);
        else:
            $this->set('listausuarios', $c_pagina[$pagina]);
            $this->set('pagina', $pagina);
            $this->set('q_paginas', ceil($q_paginas));
        endif;
        $this->set('ordem', $ordem);
        $this->set('linhas', $linhas);
        $this->set('direcao', $direcao);

        // $this->set('listausuarios', $this->User->find('all'));
    }

    public function delete($id = NULL) {

        // pr($id);
        // die();
        $usuario_id = $this->User->find('first', array('conditions' => array('Userestagio.numero' => $id)));
        // pr($usuario_id);
        // die();

        $this->loadModel('Aluno');
        $aluno = $this->Aluno->find('first', array('conditions' => array('Aluno.registro' => $id)));
        $this->loadModel('Estudante');
        $alunonovo = $this->Estudante->find('first', array('conditions' => array('Estudante.registro' => $id)));
        $this->loadModel('Professor');
        $professor = $this->Professor->find('first', array('conditions' => array('Professor.siape' => $id)));
        $this->loadModel('Supervisor');
        $supervisor = $this->Supervisor->find('first', array('conditions' => array('Supervisor.cress' => $id)));

        if ($aluno or $alunonovo or $professor or $supervisor) {
            $this->Session->setFlash('Usuário existe como aluno, estudanate, professor ou supervisor');
            $this->redirect('/Userestagios/listausuarios');
        } else {
            $this->Userestagio->delete($usuario_id['Userestagio']['id']);
            $this->Session->setFlash('Registro excluído');
            $this->redirect('/Userestagios/listausuarios/');
        }
    }

    public function view($id = NULL) {

        $usuario = $this->Userestagio->find('first', array(
            'conditions' => array('Userestagio.numero' => $id)
        ));

        // pr($usuario);

        if ($usuario['Role']['id'] == 2) {
            // echo "Estudante";
            $this->loadModel("Aluno");
            $aluno = $this->Aluno->find('first', array(
                'conditions' => array('Aluno.registro' => $id)
            ));
            // pr($aluno);
            if (!$aluno) {
                $this->loadModel("Estudante");
                $alunonovo = $this->Estudante->find('first', array(
                    'conditions' => array('Estudante.registro' => $id)
                ));
                // pr($alunonovo);
            }

            if (isset($aluno) && !(empty($aluno))):
            // pr($aluno);
            elseif (isset($alunonovo) && !(empty($alunonovo))):
            // pr($alunonovo);
            endif;
            // die();
        } elseif ($usuario['Role']['id'] == 3) {
            // echo "Professor";
            $this->loadModel('Professor');
            $professor = $this->Professor->find('first', array(
                'conditions' => array('Professor.siape' => $id)
            ));
        } elseif ($usuario['Role']['id'] == 4) {
            // echo "Supervisor";
            $this->loadModel('Supervisor');
            $supervisor = $this->Supervisor->find('first', array(
                'conditions' => array('Supervisor.cress' => $id)
            ));
        }

        $this->set('usuario', $usuario);
        if (isset($aluno) && !(empty($aluno))):
            $this->set('aluno', $aluno);
        elseif (isset($alunonovo) && !(empty($alunonovo))):
            $this->set('alunonovo', $alunonovo);
        elseif (isset($professor) && !(empty($professor))):
            $this->set('professor', $professor);
        elseif (isset($supervisor) && !(empty($supervisor))):
            $this->set('supervisor', $supervisor);
        endif;
    }

    public function edit($id = NULL) {

        $this->Userestagio->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Userestagio->read();
        } else {
            pr($this->data);
            $this->Userestagio->save($this->data);
            // print_r($this->data);
            $this->Session->setFlash("Atualizado");

            $this->redirect('/Userestagios/view/' . $this->data['Userestagio']['numero']);
        }
    }

    public function alternarusuario() {

        //  pr($this->data);
        $categoria = $this->Session->read('id_categoria');
        //  pr($categoria);
        if ($categoria == 1):
            echo "Administrador";

            if (empty($this->data)) {
                $this->data = $this->User->read();
            } else {
                pr($this->data);
                if ($this->data['Userestagio']['role'] == 2) {
                    // $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                    $this->loadModel('Aluno');
                    $aluno_id = $this->Aluno->findByRegistro($this->data['Userestagio']['numero']);
                    if ($aluno_id) {
                        $this->Session->write('menu_aluno', 'estagiario');
                        $this->Session->write('menu_id_aluno', $aluno_id['Aluno']['id']);
                        $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);

                    } else {
                        $this->loadModel('Estudante');
                        $aluno_id = $this->Estudante->findByRegistro($this->data['Userestagio']['numero']);
                        if ($aluno_id) {
                            $this->Session->write('menu_aluno', 'alunonovo');
                            $this->Session->write('menu_id_aluno', $aluno_id['Alunonovo']['id']);
                            $this->redirect('/Estudantes/view/' . $aluno_id['Alunonovo']['id']);
                        } else {
                            $this->Session->write('menu_aluno', 'semcadastro');
                            $this->Session->write('menu_id_aluno', 0);
                            // $this->Session->setFlash('Estudante novo sem cadastro');
                            // Tem que impedir que estudante nao cadastro possa continuar
                            $this->redirect('/Estudantes/add/');
                        }
                    }
                }
                //  pr($this->data);
                // $this->Session->write();
            }
        endif;
    }

    public function padroniza() {

        $emails = $this->Userestagio->find('all', array('fields' => array('id', 'email', 'timestamp')));
        // pr($emails);
        foreach ($emails as $c_email):
            if ($c_email['Userestagio']['timestamp'] === '0000-00-00 00:00:00'):
                // pr($c_email['User']['timestamp']);
                $this->Userestagio->query("UPDATE userestagios set timestamp = '2000-01-01 00:00:00' where id = " . $c_email['Userestagio']['id']);
            endif;
            // pr(strtolower($c_email['User']['email']));
            // $this->User->query("UPDATE userestagios set email = '" . strtolower($c_email['User']['email'] . "' where id = ". $c_email['User']['id']));
        endforeach;
        die();
    }

}

?>
