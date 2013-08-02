<?php

class MuralsController extends AppController {

    public $name = "Murals";
    public $components = array('Email');

    // var $scaffold;

    public function beforeFilter() {

        parent::beforeFilter();

        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash('Administrador');
            // Estudantes podem somente fazer inscricao
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('edit', 'index', 'view');
            // $this->Session->setFlash('Estudante');
            // Professores podem atualizar murais
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('edit', 'index', 'view');
            // $this->Session->setFlash('Professor');
            // No futuro os supervisores poderao lançar murals
        } elseif ($this->Session->read('id_categoria') === '4') {
            $this->Auth->allow('add', 'edit', 'index', 'view');
            // $this->Session->setFlash('Supervisor');
            // Todos
        } else {
            $this->Auth->allow('index', 'view');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;

        // Se o periodo não veio como parametro
        if (!$periodo) {
            // Capturo o periodo atual de estagio para o mural
            $periodo = $this->Session->read('mural_periodo');
            // Se não está na variavel da session entao pega da configuracao
            if (!$periodo) {
                $this->loadModel("Configuracao");
                $configuracao = $this->Configuracao->findById('1');
                $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
            }
            // pr($periodo);
            // die();
        }

        $this->Session->write('mural_periodo', $periodo);

        // Capturo todos os periodos para fazer o select
        $todos_periodos = $this->Mural->find('list', array(
            'fields' => array('Mural.periodo', 'Mural.periodo'),
            'group' => array('Mural.periodo'),
            'order' => array('Mural.periodo DESC')));
        // pr($todos_periodos);
        // die();
        // Capturo todos as ofertas do periodo
        $mural = $this->Mural->find('all', array(
            'conditions' => array('Mural.periodo' => $periodo),
            'order' => array('Mural.dataInscricao DESC')));
        // pr($mural);
        // die();
        // Capturo os inscritos para cada oferta de vaga de estágio
        $this->loadModel('Estagiario');
        $i = 0;
        $total_estagiarios = NULL;
        foreach ($mural as $c_mural) {
            $inscricoes = sizeof($c_mural['Inscricao']);
            // $estagio = $c_mural['Mural']['id_estagio'];
            // $instituicao = $c_mural['Instituicao']['instituicao'];
            // Calculo a quantidade de estagiarios desse mural
            $estagiarios = $this->Estagiario->find('all', array(
                'conditions' => array('Estagiario.id_instituicao = ' . "'" . $c_mural["Mural"]["id_estagio"] . "'",
                    'Estagiario.periodo = ' . "'" . $c_mural["Mural"]["periodo"] . "'")
                    )
            );
            // pr($estagiarios);
            $mural[$i]['Mural']['estagiarios'] = sizeof($estagiarios);
            $mural[$i]['Mural']['inscricoes'] = $inscricoes;

            $total_estagiarios = $total_estagiarios + sizeof($estagiarios);

            $i++;
        }

        /* Conta quantos alunos inscritos (sem repeticoes) */
        $alunos = $this->Mural->Inscricao->find('all', array(
            'fields' => array('distinct (Inscricao.id_aluno) as estudante_id', 'periodo'),
            'order' => 'Inscricao.periodo, estudante_id',
            'conditions' => array('Inscricao.periodo' => $periodo))
        );
        $total_alunos = sizeof($alunos);
        /* Finaliza conta de alunos inscritos */

        /* Discrimina os alunos estagiarios e novos */
        $inscritos = $this->Mural->Inscricao->find('all', array(
            'conditions' => array('Inscricao.periodo' => $periodo),
            'fields' => array('Inscricao.id', 'Inscricao.id_aluno', 'Aluno.nome', 'Alunonovo.nome', 'Mural.instituicao', 'Inscricao.id_instituicao', 'Inscricao.periodo'),
            'group' => array('id_aluno'),
            'order' => array('Aluno.nome' => 'asc')
        ));
        // pr($inscritos);

        /*
         * Teria que buscar nos estagiarios até o periodo atual
         */
        $alunos_estagiarios = 0;
        $alunos_novos = 0;
        foreach ($inscritos as $c_inscritos) {
            // pr($c_inscritos);
            if ($c_inscritos['Aluno']['nome']) {
                $alunos_estagiarios++;
            } else {
                $alunos_novos++;
            }
        }
        // echo "Novos: " . $alunos_novos . " Estagiarios: " . $alunos_estagiarios;
        /* Fim da descriminacao entre estagiarios e novos */

        /* Conta a quantidade total de vagas oferecidas */
        $vagas = $this->Mural->find('all', array(
            'fields' => 'Sum(vagas) as total_vagas',
            'conditions' => 'Mural.periodo = ' . "'" . $periodo . "'")
        );
        $total_vagas = $vagas[0][0]['total_vagas'];
        /* Finaliza conta das vagas */

        $this->set('todos_periodos', $todos_periodos);
        $this->set('periodo', $periodo);
        $this->set('total_alunos', $total_alunos);
        $this->set('total_vagas', $total_vagas);
        $this->set('total_estagiarios', $total_estagiarios);
        $this->set('alunos_novos', $alunos_novos);
        $this->set('alunos_estagiarios', $alunos_estagiarios);
        $this->set('mural', $mural);
    }

    public function add() {

        if (!empty($this->data)) {
            // Instituicao
            $this->loadModel('Instituicao');
            $instituicao = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id =' . $this->data['Mural']['id_estagio']),
                'fields' => 'Instituicao.instituicao'
            ));
            // pr($instituicao['Instituicao']);
            $this->request->data['Mural']['instituicao'] = $instituicao['Instituicao']['instituicao'];
            // pr($this->data);
            // die();
            if ($this->Mural->save($this->data)) {
                $this->Session->setFlash('Mural inserido');
                $id_estagio = $this->Mural->getLastInsertId();
                $this->redirect('/Murals/view/' . $id_estagio);
            }
        } else {

            // Capturo o periodo atual de estagio para o mural
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
            // die(pr($periodo));
            // Select Instituicoes
            $this->loadModel('Instituicao');
            $instituicoes = $this->Instituicao->find('list', array(
                'fields' => array('id', 'instituicao'),
                'order' => array('instituicao')
            ));
            // Inserir no topo do array
            $instituicoes[0] = '- Seleciona instituicao -';
            asort($instituicoes);
            // pr($instituicoes);
            // Select Areas
            $this->loadModel('Area');
            $areas = $this->Area->find('list', array(
                'fields' => array('id', 'area'),
                'order' => array('area')
            ));
            $areas[0] = '- Selecionar área';
            asort($areas);
            // pr($areas);
            // Select Professores
            // TODO: selecionar apenas professores de OTP
            $this->loadModel('Professor');
            $professores = $this->Professor->find('list', array(
                'fields' => array('id', 'nome'),
                'order' => array('nome')
            ));
            $professores[0] = '- Selecionar professor -';
            asort($professores);
            // pr($professores);

            $this->set('instituicoes', $instituicoes);
            $this->set('areas', $areas);
            $this->set('professores', $professores);
            $this->set('periodo', $periodo);
        }
    }

    public function view($id = null) {

        $this->Mural->id = $id;
        $this->set('mural', $this->Mural->read());
    }

    public function edit($id = NULL) {

        $this->Mural->id = $id;

        // Instituicoes para selecionar
        $instituicoes = $this->Mural->Instituicao->find('list', array(
            'fields' => array('id', 'instituicao'),
            'order' => array('instituicao')
        ));
        // pr($instituicoes);
        $this->set('instituicoes', $instituicoes);

        // A lista de professores para selecionar
        $this->loadModel('Professor');
        $professores = $this->Professor->find('list', array(
            'fidelds' => array('id', 'nome'), 'order' => 'nome'));
        $professores[0] = "Selecione";
        $this->set('professores', $professores);

        // A lista das areas para selecionar
        $this->loadModel('Area');
        $areas = $this->Area->find('list', array(
            'fields' => array('id', 'area')));
        $areas[0] = "Selecione";
        $this->set('areas', $areas);

        if (empty($this->data)) {

            $this->data = $this->Mural->read();

        } else {

            /* Coloquei para ignorar as validações. Eh ruin mas senao nao funcionava */
            if ($this->Mural->save($this->data, FALSE)) {
                $this->Session->setFlash("Dados atualizados");
                //  die();
                $this->redirect('/Murals/view/' . $id);
            } else {
                // pr($this->validationErrors);
                $this->Session->setFlash("Error: Dados não atualizados");
                // $this->redirect('/Murals/view/' . $id);
            }
        }
    }

    public function delete($id = Null) {

        // Busco se ha inscricoes nesse mural
        $inscricoes = $this->Mural->find('first', array(
            'conditions' => array('Mural.id' => $id)
        ));

        // Se ha inscricoes entao primeiro tem que ser excluidas
        if ($inscricoes['Inscricao']) {

            $this->Session->setFlash('Tem que excluir primeiro todos os alunos inscritos para este estágio');
            $this->redirect('/Inscricaos/index/' . $id);
        } else {

            $this->Mural->delete();
            $this->Session->setFlash('Registro excluído');
            $this->redirect('/Murals/index/');
        }
    }

    public function publicagoogle($id = NULL) {

        $this->Mural->id = $id;
        $mural = $this->Mural->findAllById($id);
        // pr($mural);
        $this->Email->smtpOptions = array(
            'port' => '465',
            'timeout' => '30',
            'host' => 'ssl://smtp.gmail.com',
            'username' => 'estagio.ess@gmail.com',
            'password' => 'e$tagi0ess',
        );
        /* Set delivery method */
        $this->Email->delivery = 'smtp';
        //$this->Email->to = $user['email'];
        $this->Email->to = 'estagio_ess@googlegroups.com';
        $this->Email->subject = $mural[0]['Mural']['instituicao'];
        $this->Email->replyTo = '"ESS/UFRJ - Estágio" <estagio@ess.ufrj.br>';
        $this->Email->from = '"ESS/UFRJ - Estágio" <estagio@ess.ufrj.br>';
        $this->Email->template = 'google'; // note no '.ctp'
        //Send as 'html', 'text' or 'both' (default is 'text')
        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        /* Do not pass any args to send() */
        $this->set('mural', $mural);
        $this->Email->send();
        /* Check for SMTP errors. */
        $this->set('smtp-errors', $this->Email->smtpError);

        $this->redirect('https://groups.google.com/forum/?fromgroups&pli=1#!forum/estagio_ess');
    }

    public function publicacartaz($id = NULL) {

        $this->Mural->id = $id;
        $mural = $this->Mural->findAllById($id);
        // pr($mural);
        $this->set('mural', $mural);

        $this->layout = "pdf";
        $this->render();
    }

}

?>
