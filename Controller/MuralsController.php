<?php

class MuralsController extends AppController {

    public $name = "Murals";
    public $components = array('Email', 'Auth');

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
        // Capturo todas as ofertas do periodo
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
            $estagio = $c_mural['Mural']['id_estagio'];
            // die();
            $q_inscricoes = $this->Mural->find('first', array(
            'conditions' => array('Mural.periodo' => $periodo, 'Mural.id' => $c_mural['Mural']['id']),
            'order' => array('Mural.dataInscricao DESC'))); 
            // pr($q_inscricoes['Inscricao']);
            // die();
            
            // Calculo a quantidade de estagiarios desse mural
            // echo $c_mural["Mural"]["id_estagio"];
            // echo " ";
            // echo $c_mural["Mural"]["periodo"];
            $estagiarios = $this->Estagiario->find('all', array(
                'conditions' => array(
                    'Estagiario.instituicao_id' => $c_mural["Mural"]["id_estagio"], 
                    'Estagiario.periodo' => $c_mural["Mural"]["periodo"])
                    )
            );
            // pr($estagiarios);
            // die('estagiarios');
            
            $mural[$i]['Mural']['estagiarios'] = sizeof($estagiarios);
            $mural[$i]['Mural']['inscricoes'] = sizeof($q_inscricoes['Inscricao']);

            $total_estagiarios = $total_estagiarios + sizeof($estagiarios);

            $i++;
        }

        /* Conta o total de alunos inscritos (sem repeticoes) */
        $total_alunos = $this->Mural->Inscricao->find('count', array(
            'fields' => array('Inscricao.aluno_id', 'Aluno.registro', 'Alunonovo.registro'),
            'group' => 'Inscricao.aluno_id',
            'order' => array('Inscricao.aluno_id'),
            'conditions' => array('Inscricao.periodo' => $periodo))
        );
        // pr($total_alunos);
        /* Finaliza conta de alunos inscritos */

        /* Discrimina os alunos estagiarios */
        $alunos_estagiarios = $this->Mural->Inscricao->find('count', array(
            'conditions' => array('Inscricao.periodo' => $periodo,
                'NOT' => array('Aluno.registro' => '')),
            'fields' => array('Aluno.registro)'),
            'group' => array('Aluno.registro'),
            'order' => array('Aluno.registro' => 'ASC')
        ));
        // pr($alunos_estagiarios);

        /* Discrimina os alunos novos */
        $alunos_novos = $this->Mural->Inscricao->find('count', array(
            'conditions' => array('Inscricao.periodo' => $periodo,
                'NOT' => array('Alunonovo.registro' => ''),
                'Aluno.registro' => ''),
            'fields' => array('Alunonovo.registro'),
            'group' => array('Alunonovo.registro'),
            'order' => array('Alunonovo.registro' => 'ASC')
        ));
        // pr($alunos_novos);

        /* Aluno estagiario que não está na tabela Alunonovo */
        $alunos_nao_novos = $this->Mural->Inscricao->find('count', array(
            'conditions' => array('Inscricao.periodo' => $periodo,
                'Alunonovo.registro' => '',
                'NOT' => array('Aluno.registro' => '')),
            'fields' => array('Aluno.registro'),
            'group' => array('Aluno.registro'),
            'order' => array('Aluno.registro' => 'ASC')
        ));
        // pr($alunos_nao_novos);

        /* Fim da descriminacao entre estagiarios e novos */

        /* Conta a quantidade total de vagas oferecidas */
        $vagas = $this->Mural->find('all', array(
            'fields' => 'Sum(vagas) as total_vagas',
            'conditions' => 'Mural.periodo = ' . "'" . $periodo . "'")
        );
        $total_vagas = $vagas[0][0]['total_vagas'];
        // pr($total_vagas);
        // die('Total');
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

        // pr($this->data);
        
        if (!empty($this->data)) {
            // Instituicao
            $this->loadModel('Instituicao');
            $instituicao = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id =' . $this->data['Mural']['id_estagio']),
                'fields' => 'Instituicao.instituicao'
            ));
            // pr($instituicao['Instituicao']);
            if ($instituicao)
                // pr($instituicao['Instituicao']['instituicao']);
                if (strlen($instituicao['Instituicao']['instituicao']) > 99):
                    $instituicao['Instituicao']['instituicao'] = substr($instituicao['Instituicao']['instituicao'], 0, 99);
                endif;
                echo $this->request->data['Mural']['instituicao'] = $instituicao['Instituicao']['instituicao'];
                pr($this->data);
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

    public function delete($id = NULL) {

        // Busco se ha inscricoes nesse mural
        $inscricoes = $this->Mural->find('first', array(
            'conditions' => array('Mural.id' => $id)
        ));
        // print_r($id);
        // die();
        // Se ha inscricoes entao primeiro tem que ser excluidas
        if ($inscricoes['Inscricao']) {

            $this->Session->setFlash('Tem que excluir primeiro todos os alunos inscritos para este estágio');
            $this->redirect('/Inscricaos/index/' . $id);
        } else {

            $this->Mural->delete($id);
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

        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

}

?>
