<?php

class MuralestagiosController extends AppController {

    public $name = "Muralestagios";
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

        }
        $this->Session->write('mural_periodo', $periodo);
        
        // Capturo todos os periodos para fazer o select
        $todos_periodos = $this->Muralestagio->find('list', array(
            'fields' => array('Muralestagio.periodo', 'Muralestagio.periodo'),
            'group' => array('Muralestagio.periodo'),
            'order' => array('Muralestagio.periodo DESC')));
        // pr($todos_periodos);
        // die();
    
        /* Capturo todas as ofertas do periodo */
        $mural = $this->Muralestagio->find('all', array(
            'conditions' => array('Muralestagio.periodo' => $periodo),
            'order' => array('Muralestagio.dataInscricao DESC')));
        // pr($mural);
        // die('mural1');
        // Capturo os inscritos para cada oferta de vaga de estágio
        $this->loadModel('Estagiario');
        $i = 0;
        $total_vagas = NULL;
        $total_estagiarios = NULL;
        foreach ($mural as $c_mural) {
            // pr($c_mural);

            $estagiarios = $this->Estagiario->find('all', [
                'fields' => ['Instituicao.instituicao'],
                'conditions' => ['Estagiario.instituicao_id' => $c_mural['Muralestagio']['id_estagio'],
                    'Estagiario.periodo' => $periodo]
            ]);
            // $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // pr(count($estagiarios));

            /* Quantidade de inscritos na oferta de vaga da instituciao */
            $muralporperiodo[$i]['id'] = $c_mural['Muralestagio']['id'];
            $muralporperiodo[$i]['instituicao'] = $c_mural['Muralestagio']['instituicao'];
            $muralporperiodo[$i]['instituicao_id'] = $c_mural['Muralestagio']['id_estagio'];
            $muralporperiodo[$i]['vagas'] = $c_mural['Muralestagio']['vagas'];
            $muralporperiodo[$i]['estagiarios'] = count($estagiarios);
            $muralporperiodo[$i]['inscritos'] = sizeof($c_mural['Inscricao']);
            $muralporperiodo[$i]['beneficios'] = $c_mural['Muralestagio']['beneficios'];
            $muralporperiodo[$i]['datainscricao'] = $c_mural['Muralestagio']['dataInscricao'];
            $muralporperiodo[$i]['dataselecao'] = $c_mural['Muralestagio']['dataSelecao'];
            $muralporperiodo[$i]['dataselecao'] = $c_mural['Muralestagio']['dataSelecao'];
            $muralporperiodo[$i]['horarioselecao'] = $c_mural['Muralestagio']['horarioSelecao'];
            $muralporperiodo[$i]['emailenviado'] = $c_mural['Muralestagio']['datafax'];
            $muralporperiodo[$i]['localdeinscricao'] = $c_mural['Muralestagio']['localInscricao'];
            
            $inscricoes = sizeof($c_mural['Inscricao']);
            $estagio = $c_mural['Muralestagio']['id_estagio'];
            // die();

            $total_vagas = $total_vagas + $c_mural['Muralestagio']['vagas'];
            $total_estagiarios = $total_estagiarios + $muralporperiodo[$i]['estagiarios'];
            $i++;
        }

        /* Inscricoes para a vaga de estágio */
        $this->loadModel('Inscricao');
        $inscricoes = $this->Inscricao->find('all', [
            'fields' => 'Inscricao.aluno_id',
            'conditions' => ['Inscricao.periodo' => $periodo],
            'group' => 'Inscricao.aluno_id'
        ]);
        $q_com_estagio = null;
        $q_sem_estagio = null;
        foreach ($inscricoes as $c_inscricao):
            // pr($c_inscricao['Inscricao']['aluno_id']);
            $estagiarios = $this->Estagiario->find('all', [
                'conditions' => ['Estagiario.registro' => $c_inscricao['Inscricao']['aluno_id']]
            ]);
            if ($estagiarios):
                // echo "Estudante com estágio" . "<br />";
                $q_com_estagio++;
            else:
                // echo "Estudante SEM estágio" . "<br />";
                $q_sem_estagio++;
            endif;
            // pr($estagiarios);
        endforeach;
        // die('inscricoes');

        $this->set('todos_periodos', $todos_periodos);
        $this->set('periodo', $periodo);
        $this->set('total_alunos', $q_sem_estagio + $q_com_estagio);
        $this->set('total_vagas', $total_vagas);
        $this->set('total_estagiarios', $total_estagiarios);
        $this->set('alunos_novos', $q_sem_estagio);
        $this->set('alunos_estagiarios', $q_com_estagio);
        $this->set('mural', $muralporperiodo);
    }

    public function add() {

        // pr($this->data);

        if (!empty($this->data)) {
            // Instituicao
            $this->loadModel('Instituicao');
            $instituicao = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id =' . $this->data['Muralestagio']['id_estagio']),
                'fields' => 'Instituicao.instituicao'
            ));
            // pr($instituicao['Instituicao']);
            if ($instituicao)
            // pr($instituicao['Instituicao']['instituicao']);
                if (strlen($instituicao['Instituicao']['instituicao']) > 99):
                    $instituicao['Instituicao']['instituicao'] = substr($instituicao['Instituicao']['instituicao'], 0, 99);
            endif;
            $this->request->data['Muralestagio']['instituicao'] = $instituicao['Instituicao']['instituicao'];
            // pr($this->data);
            // die();
            if ($this->Muralestagio->save($this->data)) {
                $this->Session->setFlash('Muralestagio inserido');
                $id_estagio = $this->Muralestagio->getLastInsertId();
                $this->redirect('/Muralestagios/view/' . $id_estagio);
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
            $this->loadModel('Areaestagio');
            $areas = $this->Areaestagio->find('list', array(
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

        $this->Muralestagio->id = $id;
        $this->set('mural', $this->Muralestagio->read());
    }

    public function edit($id = NULL) {

        $this->Muralestagio->id = $id;

        // Instituicoes para selecionar
        $instituicoes = $this->Muralestagio->Instituicao->find('list', array(
            'fields' => array('id', 'instituicao'),
            'order' => array('instituicao')
        ));
        // pr($instituicoes);
        $this->set('instituicoes', $instituicoes);

        // A lista de professores para selecionar
        $this->loadModel('Professor');
        $professores = $this->Professor->find('list', array(
            'fidelds' => array('id', 'nome'), 'order' => 'nome'));
        // pr($professores);
        $professores[0] = "Selecione";
        $this->set('professores', $professores);

        // A lista das areas para selecionar
        $this->loadModel('Areaestagio');
        $areas = $this->Areaestagio->find('list', array(
            'fields' => array('id', 'area')));
        // pr($areas);
        $areas[0] = "Selecione";
        $this->set('areas', $areas);

        if (empty($this->data)) {

            $this->data = $this->Muralestagio->read();
        } else {

            /* Coloquei para ignorar as validações. Eh ruin mas senao nao funcionava */
            if ($this->Muralestagio->save($this->data, FALSE)) {
                $this->Session->setFlash("Dados atualizados");
                //  die();
                $this->redirect('/Muralestagios/view/' . $id);
            } else {
                // pr($this->validationErrors);
                $this->Session->setFlash("Error: Dados não atualizados");
                // $this->redirect('/Muralestagios/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        // Busco se ha inscricoes nesse mural
        $inscricoes = $this->Muralestagio->find('first', array(
            'conditions' => array('Muralestagio.id' => $id)
        ));
        // print_r($id);
        // die();
        // Se ha inscricoes entao primeiro tem que ser excluidas
        if ($inscricoes['Inscricao']) {

            $this->Session->setFlash('Tem que excluir primeiro todos os alunos inscritos para este estágio');
            $this->redirect('/Inscricoes/index/' . $id);
        } else {

            $this->Muralestagio->delete($id);
            $this->Session->setFlash('Registro excluído');
            $this->redirect('/Muralestagio/index/');
        }
    }

    public function publicagoogle($id = NULL) {

        $this->Muralestagio->id = $id;
        $mural = $this->Muralestagio->find('first',
                ['conditions' => ['Muralestagio.id' => $id]]);
        pr($mural);
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
        $this->Email->subject = $mural[0]['Muralestagio']['instituicao'];
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

        $this->Muralestagio->id = $id;
        $mural = $this->Muralestagio->findAllById($id);
        // pr($mural);
        $this->set('mural', $mural);

        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

}

?>
