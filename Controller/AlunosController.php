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
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit', 'avaliacaosolicita', 'avaliacaoverifica', 'avaliacaoedita', 'avaliacaoimprime');
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

        $this->Aluno->id = $id;

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
        if (isset($nome))
            $this->request->data['Aluno']['nome'] = $nome;

        $this->Paginate = array(
            'limit' => 10,
            'order' => array(
                'Aluno.nome' => 'asc')
        );

        if (!empty($this->data['Aluno']['nome'])) {

            $condicao = array('Aluno.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
            $alunos = $this->Aluno->find('all', array('conditions' => $condicao));
            // pr($alunos);
            // die();
            // Nenhum resultado
            if (empty($alunos)) {
                $this->loadModel('Alunonovo');
                $condicao = array('Alunonovo.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
                $alunonovos = $this->Alunonovo->find('all', array('conditions' => $condicao));
                if (empty($alunonovos)) {
                    $this->Session->setFlash("Não foram encontrados registros");
                } else {
                    $this->set('alunos', $this->paginate('Alunonovo', $condicao));
                    $this->set('nome', $this->data['Aluno']['nome']);
                }
            } else {
                $this->set('alunos', $this->paginate('Aluno', $condicao));
                $this->set('nome', $this->data['Aluno']['nome']);
            }
        }
    }

    public function busca_dre() {

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

    /*
     * Funcao para atualizar dados do supervisor do estagiario
     */

    public function avaliacaosolicita() {

        // Verificar periodo da folha de avaliação
        // pr($this->data);
        if ($this->data) {
            $aluno = $this->Aluno->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $this->data['Aluno']['registro']),
                'order' => array('Estagiario.nivel DESC')
            ));
            // pr($aluno['Supervisor']);
            // die("avaliacao");
            if ($aluno) {
                if (!empty($aluno['Supervisor']['id'])) {
                    $this->Session->setFlash("Verificar e completar dados do supervisor da instituicao.");
                    // $this->redirect('/Alunos/avaliacaoverifica/' . $aluno['Supervisor']['id'] . '/' . $this->data['Aluno']['registro']);
                    $this->redirect('/Alunos/avaliacaoedita/' . $aluno['Supervisor']['id'] . '/' . $this->data['Aluno']['registro']);
                } else {
                    $this->Session->setFlash("Não foi indicado supervisor da instituicao. Retorna para solicitar termo de compromisso");
                    $this->redirect('/Inscricaos/termocompromisso/' . $aluno['Aluno']['registro']);
                }
            } else {
                $this->Session->setFlash("Não há estágios cadastrados para este estudante");
            }
        }
    }

    public function avaliacaoverifica() {

        $registro = $this->request->params['pass'][1];
        $estagiario = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));

        if ($estagiario) {
            $this->set('professor', $estagiario['Professor']['nome']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
        }

        // $this->redirect('/Alunos/avaliacaoedita/' . $estagiario['Supervisor']['id'] . '/' . $this->$estagiario['Aluno']['registro']);
    }

    public function avaliacaoedita() {

        // pr($this->request->params);
        $id_supervisor = $this->request->params['pass'][0];
        $registro = $this->request->params['pass'][1];

        // pr($registro);
        $estagiario = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));
        // pr($estagiario);
        if ($estagiario) {
            $this->set('aluno', $estagiario['Aluno']['nome']);
            $this->set('registro', $estagiario['Aluno']['registro']);            
            $this->set('professor', $estagiario['Professor']['nome']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
            // die("empty");
        }
        // die("avaliacaoedita");

        $this->loadModel('Supervisor');
        $this->Supervisor->id = $id_supervisor;

        if (empty($this->data)) {
            // die("empty");
            $this->data = $this->Supervisor->read();
        } else {
            // print_r($this->data);
            // die("avaliacaoedita");

            if (!$this->data['Supervisor']['cress']) {
                $this->Session->setFlash("O número de CRESS é obrigatório");
                $this->redirect('/Alunos/avaliacaosolicita/' . $id_supervisor);
                die("O número de Cress é obrigatório");
            }

            if (!$this->data['Supervisor']['nome']) {
                $this->Session->setFlash("O nome do supervisor é obrigatório");
                $this->redirect('/Alunos/avaliacaoedita/' . $id_supervisor);
                die("O nome do supervisor é obrigatório");
            }

            if ((!$this->data['Supervisor']['celular']) && (!$this->data['Supervisor']['telefone'])) {
                $this->Session->setFlash("O número de telefone ou celular é obrigatório");
                $this->redirect('/Alunos/avaliacaoedita/' . $id_supervisor);
                die("O número de telefone ou celular é obrigatório");
            }

            if (!$this->data['Supervisor']['email']) {
                $this->Session->setFlash("O endereço de email é obrigatório");
                $this->redirect('/Alunos/avaliacaoedita/' . $id_supervisor);
                die("O email é obrigatório");
            }

            if ($this->Supervisor->save($this->data)) {
                // die();
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Alunos/avaliacaoimprime/' . $registro);
            }
        }
    }

    public function avaliacaoimprime() {

        $registro = $this->request->params['pass'][0];

        $aluno = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));

        // pr($aluno);
        // die();

        $estudante = $aluno['Aluno']['nome'];
        $registro = $aluno['Aluno']['registro'];
        $nivel = $aluno['Estagiario']['nivel'];
        $periodo = $aluno['Estagiario']['periodo'];
        $supervisor = $aluno['Supervisor']['nome'];
        $cress = $aluno['Supervisor']['cress'];
        $telefone = $aluno['Supervisor']['telefone'];
        $celular = $aluno['Supervisor']['celular'];
        $email = $aluno['Supervisor']['email'];
        $instituicao = $aluno['Instituicao']['instituicao'];
        $endereco_inst = $aluno['Instituicao']['endereco'];
        $professor = $aluno['Professor']['nome'];

        $this->set('estudante', $estudante);
        $this->set('registro', $registro);
        $this->set('nivel', $nivel);
        $this->set('periodo', $periodo);
        $this->set('supervisor', $supervisor);
        $this->set('cress', $cress);
        $this->set('telefone', $telefone);
        $this->set('celular', $celular);
        $this->set('email', $email);
        $this->set('instituicao', $instituicao);
        $this->set('endereco_inst', $endereco_inst);
        $this->set('professor', $professor);

        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

}

?>
