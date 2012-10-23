<?php

class AlunosController extends AppController {

    public $name = 'Alunos';

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/users/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Aluno.nome' => 'asc')
        );

        $this->set('alunos', $this->paginate('Aluno'));
    }

    public function view($id = NULL) {

        // echo "Aluno";
        // die(pr($this->Session->read('numero')));
        // Se eh estudante somente o próprio pode ver
        if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero'))) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Aluno->findByRegistro($this->Session->read('numero'));
            if ($id != $verifica['Aluno']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Murals/index");
                die("Não autorizado");
            }
        }

        // $this->loadModel('Estagiario');
        $instituicao = $this->Aluno->findById($id);
        // print_r($instituicao);
        // die();
        $aluno = $instituicao['Aluno'];
        $estagios = $instituicao['Estagiario'];

        // Pego a informacao sobre o conteudo dos estagios realizados
        $instituicoes = $this->Aluno->Estagiario->find('all', array(
            'conditions' => array('Estagiario.id_aluno=' . $id)
                )
        );
        // print_r($instituicoes);
        // die();
        $this->set('instituicoes', $instituicoes);

        $proximo = $this->Aluno->find('neighbors', array(
            'field' => 'nome', 'value' => $aluno['nome']));

        $this->set('registro_next', $proximo['next']['Aluno']['id']);
        $this->set('registro_prev', $proximo['prev']['Aluno']['id']);
        // $this->set('alunos', $this->paginate('Aluno', array('id'=>$id)));
        $this->set('alunos', $aluno);
        $this->set('estagios', $estagios);
    }

    public function edit($id = NULL) {

        if ($this->Session->read('numero')) {
            $verifica = $this->Aluno->findByRegistro($this->Session->read('numero'));
            if ($id != $verifica['Aluno']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Murals/index");
                die("Não autorizado");
            }
        }

        $this->request->Aluno->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Aluno->read();
        } else {

            $duplicada = $this->Aluno->findByRegistro($this->data['Aluno']['registro']);
            if ($duplicada)
                $this->Session->setFlash("Este número de aluno já está cadastrado");

            if ($this->Aluno->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");

                // Verfico se esta fazendo inscricao para selecao de estagio
                $inscricao_selecao_estagio = $this->Session->read('id_instituicao');
                // Ainda nao posso apagar
                // $this->Session->delete('id_instituicao');
                // Verifico se foi chamado desde solicitacao do termo
                $registro_termo = $this->Session->read('termo');
                // $this->Session->delete('termo');

                if ($inscricao_selecao_estagio) {
                    $this->redirect('/Inscricaos/inscricao/' . $this->data['Aluno']['registro']);
                } elseif ($registro_termo) {
                    $this->redirect('/Inscricaos/termocompromisso/' . $registro_termo);
                } else {
                    $this->redirect('/Alunos/view/' . $id);
                }
            }
        }
    }

    public function delete($id = NULL) {

        // Se tem pelo menos um estagio nao excluir
        $estagiario = $this->Aluno->Estagiario->findById_aluno($id);
        if ($estagiario) {
            $this->Session->setFlash('Aluno com estágios não foi excluido. Exclua os estágios primeiro.');
            $this->redirect(array('action' => 'view', $id));
        } else {
            $this->Aluno->delete($id);
            $this->Session->setFlash('O registro ' . $id . ' foi excluido.');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function busca($nome = NULL) {

        // Para paginar os resultados da busca por nome
        if ($nome)
            $this->data['Aluno']['nome'] = $nome;

        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Aluno.nome' => 'asc')
        );

        if (!empty($this->data['Aluno']['nome'])) {

            $condicao = array('Aluno.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
            $alunos = $this->Aluno->find('all', array('conditions' => $condicao));

            // Nenhum resultado
            if (empty($alunos)) {
                $this->loadModel('Alunonovo');
                $condicao = array('Alunonovo.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
                $alunonovos = $this->Alunonovo->find('all', array('conditions' => $condicao));
                if (empty($alunonovos)) {
                    $this->Session->setFlash("Não foram encontrados registros");
                } else {
                    $this->set('alunos', $this->paginate($condicao));
                    $this->set('nome', $this->data['Aluno']['nome']);
                }
            } else {
                $this->set('alunos', $this->paginate($condicao));
                $this->set('nome', $this->data['Aluno']['nome']);
            }
        }
    }

    public function busca_dre($registro = NULL) {

        if (!empty($this->data['Aluno']['registro'])) {
            $alunos = $this->Aluno->findAllByRegistro($this->data['Aluno']['registro']);
            if (empty($alunos)) {
                // Teria que buscar na tabela alunos_novos
                $this->loadModel('Alunonovo');
                $alunonovos = $this->Alunonovo->findAllByRegistro($this->data['Aluno']['registro']);
                // pr($alunonovos);
                if (empty($alunonovos)) {
                    $this->Session->setFlash("Não foram encontrados registros do aluno");
                    $this->redirect('/Alunos/busca');
                } else {
                    $this->set('alunos', $alunonovos);
                }
            } else {
                $this->set('alunos', $alunos);
            }
        }
    }

    /*
     * id eh o numero de registro
     */

    public function busca_email() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByEmail($this->data['Aluno']['email']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Session->setFlash("Não foram encontrados registros do email aluno");
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunos/busca');
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function busca_cpf() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByCpf($this->data['Aluno']['cpf']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Session->setFlash("Não foram encontrados registros do CPF");
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunos/busca');
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    /*
     * O id eh o numero de registro
     */

    public function add($id = NULL) {

        if (!empty($this->data)) {
            // pr($this->data);

            if ($this->Aluno->save($this->data)) {
                $this->Session->setFlash('Dados do aluno inseridos!');
                $this->Aluno->getLastInsertId();
                $this->redirect('/Estagiarios/add/' . $this->Aluno->getLastInsertId());
            }
        }

        if ($id) {

            // Primeiro verifico se ja nao esta cadastrado
            $alunocadastrado = $this->Aluno->find('first', array(
                'conditions' => array('Aluno.registro' => $id)
                    ));
            if (!empty($alunocadastrado)) {
                $this->Session->setFlash("Aluno já cadastrado");
                $this->redirect('/Alunos/view/' . $alunocadastrado['Aluno']['id']);
            }

            // Logo busco entre os alunos novos
            $this->loadModel('Alunonovo');
            $alunonovo = $this->Alunonovo->find('first', array(
                'conditions' => array('Alunonovo.registro' => $id)
                    ));
            // pr($alunonovo);
            $this->set('alunonovo', $alunonovo);
        }
        // die();
        if ($id)
            $this->set('registro', $id);
    }

}

?>
