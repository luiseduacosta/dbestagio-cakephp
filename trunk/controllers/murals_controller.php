<?php

class MuralsController extends AppController {

    var $name = "Murals";
    var $components = array('Email');
    // var $scaffold;

    function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Acl->check($this->Session->read('user'), 'controllers', '*')) {
            $this->Auth->allowedActions = array('*');
            $this->Session->setFlash('Administrador');
        // No futuro os supervisores poderao lançar murals
        } elseif ($this->Acl->check($this->Session->read('user'), 'murals', 'create')) {
            $this->Auth->allowedActions = array('add', 'edit', 'index', 'view');
            $this->Session->setFlash('Supervisor');
        // Todos
        } else {
            $this->Auth->allowedActions = array('index', 'view');
        }
        // die(pr($this->Session->read('user')));
    }

    function index($periodo = NULL) {

        // Capturo o periodo atual de estagio para o mural
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
        // $periodo = '2010-1';

        $i = 0;
        $mural = $this->Mural->find('all', array(
                    'conditions' => array('Mural.periodo' => $periodo),
                    'order' => array('Mural.dataInscricao' => 'DESC')));

        foreach ($mural as $c_mural) {
            $inscricoes = sizeof($c_mural['Inscricao']);
            $mural[$i]['Mural']['inscricoes'] = $inscricoes;
            $i++;
        }

        /* Conta quantos alunos inscritos (sem repeticoes) */
        $alunos = $this->Mural->Inscricao->find('all', array(
                    'fields' => array('distinct (id_aluno) as estudante_id', 'periodo'),
                    'order' => 'periodo, estudante_id',
                    'conditions' => 'Inscricao.periodo = ' . "'" . $periodo . "'")
        );
        $total_alunos = sizeof($alunos);
        /* Finaliza conta de alunos inscritos */

        /* Discrimina os alunos estagiarios e novos */
        $this->loadModel('Inscricao');
        $inscritos = $this->Inscricao->find('all',
                        array(
                            'conditions' => array('Inscricao.periodo' => $periodo),
                            'fields' => array('Inscricao.id', 'Inscricao.id_aluno', 'Aluno.nome', 'Alunonovo.nome', 'Mural.instituicao', 'Inscricao.id_instituicao', 'Inscricao.periodo'),
                            'group' => array('id_aluno'),
                            'order' => array('Aluno.nome' => 'asc')
                ));
        // pr($inscritos);

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

        /* Conta a quantidade de vagas oferecidas */
        $this->loadModel('Mural');
        $vagas = $this->Mural->find('all', array(
                    'fields' => 'Sum(vagas) as total_vagas',
                    'conditions' => 'Mural.periodo = ' . "'" . $periodo . "'")
        );
        $total_vagas = $vagas[0][0]['total_vagas'];
        /* Finaliza conta das vagas */

        $this->set('periodo', $periodo);
        $this->set('total_alunos', $total_alunos);
        $this->set('total_vagas', $total_vagas);
        $this->set('alunos_novos', $alunos_novos);
        $this->set('alunos_estagiarios', $alunos_estagiarios);
        $this->set('mural', $mural);
    }

    function add() {

        if (!empty($this->data)) {
            // Instituicao
            $this->loadModel('Instituicao');
            $instituicao = $this->Instituicao->find('first', array(
                        'conditions' => array('Instituicao.id =' . $this->data['Mural']['id_estagio']),
                        'fields' => 'Instituicao.instituicao'
                    ));
            // pr($instituicao['Instituicao']);
            $this->data['Mural']['instituicao'] = $instituicao['Instituicao']['instituicao'];
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
            $areas[0] = 'Selecionar área';
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

    function view($id = null) {
        $this->Mural->id = $id;
        $this->set('mural', $this->Mural->read());
    }

    function edit($id = NULL) {

        $this->Mural->id = $id;

        if (empty($this->data)) {

            // Instituicoes
            $this->loadModel('Instituicao');
            $instituicoes = $this->Instituicao->find('list', array(
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

            $this->data = $this->Mural->read();
        } else {
            $this->loadModel('Instituicao');
            $id_instituicao = $this->Instituicao->find('first', array(
                        'conditions' => array('Instituicao.id' => $this->data['Mural']['id_estagio']),
                        'fields' => array('instituicao')
                    ));
            $this->data['Mural']['instituicao'] = $id_instituicao['Instituicao']['instituicao'];
            // pr($this->data);
            if ($this->Mural->save($this->data)) {
                $this->Session->setFlash("Dados atualizados");
                $this->redirect('/Murals/view/' . $id);
            } else {
                $this->Session->setFlash("Error: Dados não atualizados");
                // $this->redirect('/Murals/view/' . $id);
            }
        }
    }

    function delete($id = Null) {

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

    function publicagoogle($id = NULL) {

        $this->Mural->id = $id;
        $mural = $this->Mural->findAllById($id);
        // pr($mural);
        $this->Email->smtpOptions = array(
            'port' => '465',
            'timeout' => '30',
            'host' => 'ssl://smtp.gmail.com',
            'username' => 'estagio.ess@gmai.com',
            'password' => 'essufrjestagio',
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

    function publicacartaz($id = NULL) {

        $this->Mural->id = $id;
        $mural = $this->Mural->findAllById($id);
        // pr($mural);
        $this->set('mural', $mural);

        $this->layout = "pdf";
        $this->render();
    }

}

?>
