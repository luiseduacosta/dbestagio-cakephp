<?php

class InscricaosController extends AppController {

    public $name = "Inscricaos";
    public $components = array('Email', 'Auth');
    private $Estagiario;

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'add', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('index', 'view', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/users/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index($id = NULL) {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        // echo "Período: " . $periodo;
        // die();

        $ordem = isset($_REQUEST['ordem']) ? $_REQUEST['ordem'] : "nome";
        // echo "Ordem: " . $ordem;
        // die($id);
        // Capturo o periodo de estagio para o mural
        // $periodo = $this->Session->read('mural_periodo');
        if (!$periodo) {
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
        }
        // echo "Período: " . $periodo;
        // die();

        $todosPeriodos = $this->Inscricao->find('list', array(
            'fields' => array('Inscricao.periodo', 'Inscricao.periodo'),
            'group' => array('Inscricao.periodo'),
            'order' => array('Inscricao.periodo')
        ));

        if ($id) {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.id_instituicao' => $id),
                'fields' => array('Inscricao.id', 'Inscricao.id_aluno', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Estagiario.id', 'Estagiario.periodo', 'Estagiario.id_instituicao', 'Mural.id_estagio', 'Mural.vagas', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email', 'Mural.instituicao', 'Inscricao.id_instituicao'),
                'order' => array('Aluno.nome' => 'asc'),
                    )
            );
        } else {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.periodo' => $periodo),
                'fields' => array('Inscricao.id_aluno'),
                'group' => array('Inscricao.id_aluno')
                    )
            );
        }

        // pr($inscritos);
        // die();
        // Somente se há inscritos
        if ($inscritos) {

            $i = 1;
            foreach ($inscritos as $c_inscritos) {
                // pr($c_inscritos);
                // die();
                // Busca entre os alunos estagiarios //
                $inscritos_1 = $this->Inscricao->Aluno->find('all', array(
                    'conditions' => array('Aluno.registro' => $c_inscritos['Inscricao']['id_aluno']),
                        // 'fields' => array('Alunonovo.nome')
                        )
                );
                if (!$inscritos_1) {
                    $inscritos_0 = $this->Inscricao->Alunonovo->find('all', array(
                        'conditions' => array('Alunonovo.registro' => $c_inscritos['Inscricao']['id_aluno']),
                            // 'fields' => array('Alunonovo.nome')
                            )
                    );
                    // pr($inscritos_0);
                    if ($inscritos_0) {
                        $inscritos_novos[$i]['id'] = $inscritos_0[0]['Alunonovo']['id'];
                        $inscritos_novos[$i]['nome'] = $inscritos_0[0]['Alunonovo']['nome'];
                        $inscritos_novos[$i]['registro'] = $inscritos_0[0]['Alunonovo']['registro'];
                        $inscritos_novos[$i]['nascimento'] = $inscritos_0[0]['Alunonovo']['nascimento'];
                        $inscritos_novos[$i]['codigo_telefone'] = $inscritos_0[0]['Alunonovo']['codigo_telefone'];
                        $inscritos_novos[$i]['telefone'] = $inscritos_0[0]['Alunonovo']['telefone'];
                        $inscritos_novos[$i]['codigo_celular'] = $inscritos_0[0]['Alunonovo']['codigo_celular'];
                        $inscritos_novos[$i]['celular'] = $inscritos_0[0]['Alunonovo']['celular'];
                        $inscritos_novos[$i]['email'] = $inscritos_0[0]['Alunonovo']['email'];
                        $inscritos_novos[$i]['estagiario'] = 0;
                        $criterio[] = $inscritos_novos[$i][$ordem];
                    }
                    // pr($inscritos_novos);
                    // die();
                } else {
                    $inscritos_novos[$i]['id'] = $inscritos_1[0]['Aluno']['id'];
                    $inscritos_novos[$i]['nome'] = $inscritos_1[0]['Aluno']['nome'];
                    $inscritos_novos[$i]['registro'] = $inscritos_1[0]['Aluno']['registro'];
                    $inscritos_novos[$i]['nascimento'] = $inscritos_1[0]['Aluno']['nascimento'];
                    $inscritos_novos[$i]['codigo_telefone'] = $inscritos_1[0]['Aluno']['codigo_telefone'];
                    $inscritos_novos[$i]['telefone'] = $inscritos_1[0]['Aluno']['telefone'];
                    $inscritos_novos[$i]['codigo_celular'] = $inscritos_1[0]['Aluno']['codigo_celular'];
                    $inscritos_novos[$i]['celular'] = $inscritos_1[0]['Aluno']['celular'];
                    $inscritos_novos[$i]['email'] = $inscritos_1[0]['Aluno']['email'];
                    $inscritos_novos[$i]['estagiario'] = 1;
                    $criterio[] = $inscritos_novos[$i][$ordem];
                    // pr($inscritos_novos);
                    // die();
                }
                $i++;
            }

            if (isset($ordem)) {
                array_multisort($criterio, SORT_ASC, $inscritos_novos);
            }
            // pr($inscritos_novos);
            // die();

            $this->set('periodo', $periodo);
            $this->set('todososperiodos', $todosPeriodos);
            $this->set('inscritos', $inscritos_novos);
        }
    }

    public function orfao() {

        $this->loadModel("Alunonovo");
        $this->set('orfaos', $this->Alunonovo->alunonovorfao());
    }

    public function add($id = NUL) {

        // pr($this->data);
        $this->set('id_instituicao', $id);

        // Verifico se foi preenchido o numero de registro
        if (isset($this->data['Inscricao']['id_aluno'])) {

            /* Verificacoes */
            if ((strlen($this->request->data['Inscricao']['id_aluno'])) < 9) {
                $this->Session->setFlash("Registro incorreto");
                $this->redirect('/Inscricaos/add/');
                die("Registro incorreto");
                exit;
            }
            // Verifico se ja esta em estagio. Se está atualiza
            $this->loadModel('Aluno');
            $registro = $this->data['Inscricao']['id_aluno'];
            $aluno = $this->Aluno->findByRegistro($registro, array('fields' => 'id', 'registro'));
            if ($aluno) {
                // echo "Aluno estagiario";
                $this->Session->delete('id_instituicao', $id);
                $this->Session->write('id_instituicao', $id);
                $this->redirect('/Alunos/edit/' . $aluno['Aluno']['id']);
                // Se nao esta estagiando verifico se eh um alunonovo cadastrado
            } else {
                // Verfico se eh aluno novo
                $this->loadModel('Alunonovo');
                $alunonovo = $this->Alunonovo->findByRegistro($registro);
                // die(pr($alunonovo));
                // Se nao esta cadastrado em alunonovo redireciono para cadastro
                if (empty($alunonovo)) {
                    // echo "Aluno novo nao cadastrado";
                    // Redireciono com um cookie para lembrar a origem do redirecionamento
                    $this->Session->delete('id_instituicao', $id);
                    $this->Session->write('id_instituicao', $id);
                    $this->redirect('/Alunonovos/add/' . $registro);
                    // die();
                    // Se esta cadastrado como alunonovo redireciona para /Alunonovos/edit
                } else {
                    // echo "Aluno novo cadastrado!";
                    // Redireciono com um cookie para lembrar a origem do redirecionamento
                    $this->Session->delete('id_instituicao', $id);
                    $this->Session->write('id_instituicao', $id);
                    $this->redirect("/Alunonovos/edit/" . $alunonovo['Alunonovo']['id']);
                    die("Stop");
                }
            }
            /* Fim das verificacoes */
        }
    }

    /*
     * Inscreve o aluno para seleção de estágio
     * O Id e o numero de registro
     *
     */

    public function inscricao($id = NULL) {

        // echo "Id: " . $id . "<br>";
        // die();
        if ($id) {
            // Capturo o id da instituicao de inscricao para selecao de estagio (vem tanto de aluno como de alunonvo)
            $id_instituicao = $this->Session->read('id_instituicao');
            // echo "Instituicao: " . $id_instituicao;
            // die();
            // Agora sim posso apagar
            $this->Session->delete('id_instituicao');

            /* Capturo o periodo para o registro de inscricao */
            $this->loadModel('Mural');
            $instituicao = $this->Mural->findById($id_instituicao, array('fields' => 'periodo'));
            $periodo = $instituicao['Mural']['periodo'];
            // echo "Período: " . $periodo;
            // die();

            /* Carrego o array de inscrição com os valores */
            $this->request->data['Inscricao']['periodo'] = $periodo;
            $this->request->data['Inscricao']['id_instituicao'] = $id_instituicao;
            $this->request->data['Inscricao']['data'] = date('Y-m-d');
            $this->request->data['Inscricao']['id_aluno'] = $id;

            // debug($this->data);
            // pr($this->data);
            // die();

            if ($this->Inscricao->save($this->request->data)) {
                $this->Session->setFlash("Inscrição realizada");
                $this->redirect('/Inscricaos/index/' . $id_instituicao);
            }
        }
    }

    public function view($id = NULL) {

        $inscricao = $this->Inscricao->findById($id);
        // pr($inscricao);
        $this->set('inscricao', $inscricao);
    }

    public function edit($id = NULL) {

        $this->Inscricao->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Inscricao->read();
        } else {
            if ($this->Inscricao->save($this->data)) {
                $this->Session->setFlash("Inscrição atualizada");
                $this->redirect('/Inscricaos/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        $instituicao = $this->Inscricao->findById($id, array('fields' => 'id_instituicao'));
        $this->Inscricao->delete($id);
        $this->Session->setFlash("Inscrição excluída");
        $this->redirect('/Inscricaos/index/' . $instituicao['Inscricao']['id_instituicao']);
    }

    public function emailparainstituicao($id = NULL) {

        if ($id) {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.id_instituicao' => $id),
                'fields' => array('Aluno.nome', 'Inscricao.id', 'Inscricao.id_aluno', 'Aluno.celular', 'Aluno.telefone', 'Aluno.email', 'Alunonovo.nome', 'Alunonovo.celular', 'Alunonovo.telefone', 'Alunonovo.email', 'Mural.id', 'Mural.instituicao', 'Mural.email', 'Inscricao.id_instituicao'),
                'order' => array('Aluno.nome' => 'asc', 'Alunonovo.nome' => 'asc')
                    )
            );
            // pr($inscritos);

            $i = 0;
            foreach ($inscritos as $c_inscritos) {

                if (!empty($c_inscritos['Aluno']['nome'])) {
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Aluno']['nome'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Aluno']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Aluno']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Aluno']['email'];
                    $criterio[$i]['nome'] = $c_inscritos['Aluno']['nome'];
                } else {
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Alunonovo']['nome'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Alunonovo']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Alunonovo']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Alunonovo']['email'];
                    $criterio[$i]['nome'] = $c_inscritos['Alunonovo']['nome'];
                }
                $i++;
            }

            if (isset($inscritos_ordem)) {

                asort($inscritos_ordem);

                if ($inscritos[0]['Mural']['email']) {
                    $this->Email->smtpOptions = array(
                        'port' => '465',
                        'timeout' => '30',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => 'estagio.ess',
                        'password' => 'e$tagi0ess',
                    );
                    /* Set delivery method */
                    $this->Email->delivery = 'smtp';
                    $this->Email->to = $user['email'];
                    // $this->Email->to = 'uy_luis@hotmail.com'; // $incritos[0]['Mural']['email']
                    $this->Email->to = $inscritos[0]['Mural']['email'];
                    // $this->Email->cc = array('estagio.ess@gmail.com', 'estagio@ess.ufrj.br');
                    $this->Email->subject = 'ESS/UFRJ: Estudantes inscritos para seleção de estágio';
                    $this->Email->replyTo = '"ESS/UFRJ - Coordenação de Estágio & Extensão" <estagio@ess.ufrj.br>';
                    $this->Email->from = '"ESS/UFRJ - Coordenação de Estágio & Extensão" <estagio@ess.ufrj.br>';
                    $this->Email->template = 'emailinstituicao'; // note no '.ctp'
                    // Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail

                    $this->set('instituicao', $inscritos);
                    $this->set('inscritos', $inscritos_ordem);

                    /* Do not pass any args to send() */
                    $this->Email->send();
                    /* Check for SMTP errors. */
                    $this->set('smtp-errors', $this->Email->smtpError);

                    // Informo que o email foi enviado
                    $this->loadModel("Mural");
                    $this->Mural->id = $inscritos[0]['Mural']['id'];
                    $this->Mural->savefield('datafax', date('Y-m-d'));

                    $this->Session->setFlash('Email enviado');
                    $this->redirect('/Murals/view/' . $inscritos[0]['Mural']['id']);
                }
            } else {

                $this->Session->setFlash('Imposível enviar email (falta o endereço)');
                $this->redirect('/Murals/view/' . $inscritos[0]['Mural']['id']);
            }
        }
    }

    // Captura o registro digitado pelo estudante
    public function termosolicita() {

        if ($this->request->data) {
            // pr($this->request->data);
            $registro = $this->request->data['Inscricao']['id_aluno'];
            // pr($registro);
            // die("termosoliciata");
            $this->redirect('/Inscricaos/termocompromisso/' . $registro);
        }
    }

    // Com o numero de registro busco as informacoes em estagiario ou alunonovo
    // Se nao esta cadastrado em alunonovo faço o cadastramento
    // Se nao eh estagiario eh um alunonovo entao faço cadastramento
    public function termocompromisso($id = NULL) {

        // Captura o periodo de estagio para o termo de compromisso
        // pr($id);
        // die("termocompromisso ");
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

        // die("termocompromisso ");
        // Busca em estagiarios o ultimo estagio do aluno
        // die("termocompromisso");
        $estagiario = $this->Inscricao->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $id),
            'fields' => array('Estagiario.id', 'Estagiario.periodo', 'Estagiario.turno', 'Estagiario.id_aluno', 'Estagiario.registro', 'Estagiario.nivel', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_professor', 'Aluno.id', 'Aluno.registro', 'Aluno.nome'),
            'order' => array('periodo' => 'DESC')
                )
        );
        // pr($estagiario);
        // die("termocompromisso");
        // Aluno estagiario
        if ($estagiario) {
            // echo "Aluno estagiario" . "<br />";
            // pr($estagiario);
            $periodo_ultimo = $estagiario['Estagiario']['periodo'];
            $nivel_ultimo = $estagiario['Estagiario']['nivel'];
            $turno_ultimo = $estagiario['Estagiario']['turno'];
            $instituicao_atual = $estagiario['Estagiario']['id_instituicao'];
            $supervisor_atual = $estagiario['Estagiario']['id_supervisor'];
            $professor_atual = $estagiario['Estagiario']['id_professor'];
            $aluno_nome = $estagiario['Aluno']['nome'];
            // pr($nivel_ultimo);
            // Se eh o periodo anterior adianta em uma unidade o nivel
            if ($periodo_ultimo < $periodo) {
                if ($nivel_ultimo < 4)
                    $nivel_ultimo++;
            }

            $this->set('aluno', $aluno_nome);
            // $this->set('aluno', $estagiario);
            $this->set('instituicao_atual', $instituicao_atual);
            $this->set('supervisor_atual', $supervisor_atual);
            $this->set('professor_atual', $professor_atual);
        } else {
            // Aluno nao estagiario
            // Turno incompleto (ou ignorado)
            $turno_ultimo = 'I';

            // Nivel eh I
            $nivel_ultimo = 1;
            $this->loadModel('Alunonovo');
            $alunonovo = $this->Alunonovo->findByRegistro($id);
            // die($alunonovo);
            // die("Alunonovo " . $alunonovo);
            // Aluno novo nao cadastrado: vai para cadastro e retorna
            if (!($alunonovo)) {
                $this->Session->setFlash("Aluno não cadastrado");
                $this->Session->write('termo', $id);
                // die("Aluno novo nao cadastrado: " . $id);
                $this->redirect('/Alunonovos/add/' . $id);
                die("Redireciona para cadastro de alunos novos ");
            } else {
                $this->set('aluno', $alunonovo['Alunonovo']['nome']);
            }

            $this->set('instituicao_atual', 0);
            $this->set('supervisor_atual', 0);
            $this->set('professor_atual', 0);
        }

        // Pego as instituicoes
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', array(
            'order' => 'Instituicao.instituicao',
            'fields' => array('Instituicao.id', 'Instituicao.instituicao')
                )
        );
        $instituicoes[0] = "- Selecione -";
        asort($instituicoes);
        // pr($instituicoes);
        // Pego os supervisores da instituicao atual
        if (isset($instituicao_atual)) {
            $supervisores = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id = ' . "'" . $instituicao_atual . "'")
                    )
            );
            // pr($supervisores);
            foreach ($supervisores['Supervisor'] as $c_supervisor) {
                $super_atuais[$c_supervisor['id']] = $c_supervisor['nome'];
                // pr($c_supervisor['nome']);
            }
            $super_atuais[0] = "- Selecione supervisor -";
            asort($super_atuais);
            // pr($super_atuais);
        } else {
            $super_atuais[0] = "- Selecioe supervisor -";
        }

        // Envio os dados
        $this->set('id', $id);
        $this->set('periodo', $periodo);
        $this->set('nivel', $nivel_ultimo);
        $this->set('turno', $turno_ultimo);
        $this->set('instituicoes', $instituicoes);
        $this->set('supervisores', $super_atuais);
    }

    /*
     * O id eh o numero de registro do aluno
     */

    public function termocadastra($id = NULL) {

        // Configure::write('debug', '2');
        // echo "id " . $id . "<br>";
        // pr($this->data);
        // die('514');
        // Se ja esta como estagiario pego o id para atualizar
        // $this->loadModel("Estagiario");
        $periodo_estagio = $this->Inscricao->Estagiario->find('first', array(
            'conditions' => array('Estagiario.periodo' => $this->data['Inscricao']['periodo'], 'Estagiario.registro' => $this->data['Inscricao']['id_aluno']),
            'fields' => array('Estagiario.id', 'Estagiario.id_aluno')));
        // pr($periodo_estagio);
        // die('521');
        /* Capturo os valores da area e professor da instituicao selecionada
         * Estes valores foram capturados no controller Instituicao funcao seleciona_supervisor
         */
        $id_area = $this->Session->read('id_area');
        $id_prof = $this->Session->read('id_prof');
        // Apago os cookies que foram passados na sessao
        $this->Session->delete('id_area');
        $this->Session->delete('id_prof');
        // echo $id_area . " " . $id_prof . "<br>";
        // die('531');
        // Tem que ter o id da instituicao diferente de zero
        if (empty($this->data['Inscricao']['id_instituicao'])) {
            $this->Session->setFlash('Selecione uma instituição de estágio');
            $this->redirect('/Inscricaos/termosolicita/');
            die('Faltou selecionar uma instituição');
        }
        // Estagio ja cadastrado: atualizacao.
        if ($periodo_estagio) {
            $id_estagio = $periodo_estagio['Estagiario']['id'];
            $id_aluno = $periodo_estagio['Estagiario']['id_aluno'];

            $dados = array("Estagiario" => array(
                    'id' => $id_estagio,
                    'id_aluno' => $id_aluno,
                    'registro' => $this->data['Inscricao']['id_aluno'],
                    'nivel' => $this->data['Inscricao']['nivel'],
                    'turno' => $this->data['Inscricao']['turno'],
                    'tc' => '0',
                    'tc_solicitacao' => date('Y-m-d'),
                    'periodo' => $this->data['Inscricao']['periodo'],
                    'id_professor' => $id_prof,
                    'id_instituicao' => $this->data['Inscricao']['id_instituicao'],
                    'id_supervisor' => $this->data['Inscricao']['id_supervisor'],
                    'id_area' => $id_area,
            ));

            $this->Inscricao->Estagiario->set($dados);
            if ($this->Inscricao->Estagiario->save($dados, array('validate' => TRUE))) {
                $this->Session->setFlash('Registro de estágio atualizado');
                $this->redirect('/Inscricaos/termoimprime/' . $id_estagio);
            } else {
                $errors = $this->Inscricao->Estagiario->invalidFields();
                $this->Session->setFlash(implode(', ', $errors));
                die("Error: não foi possível atualizar inscrição de estágio");
            }
        } else {
            /*
             * Aluno: pode haver duas situacoes:
             * eh um aluno que ja estava em estagio ou
             * eh um aluno novo que precisa ser cadastrado primeiro
             */
            // Verifico se ja esta cadastrado
            $this->loadModel('Aluno');
            $alunocadastrado = $this->Aluno->find('first', array(
                'conditions' => array('Aluno.registro = ' . $id)
            ));
            // pr($alunocadastrado);
            // die();
            if (empty($alunocadastrado)) {
                // echo "Aluno nao cadastrado";
                $this->loadModel('Alunonovo');
                $alunonovo = $this->Alunonovo->find('first', array(
                    'conditions' => array('Alunonovo.registro =' . $id)
                ));
                // pr($alunonovo);
                // die();
                /*
                 * Aluno nao cadastrado. Cadastrar
                 */
                $cadastroaluno = array('Aluno' => array(
                        'nome' => $alunonovo['Alunonovo']['nome'],
                        'registro' => $alunonovo['Alunonovo']['registro'],
                        'codigo_telefone' => $alunonovo['Alunonovo']['codigo_telefone'],
                        'telefone' => $alunonovo['Alunonovo']['telefone'],
                        'codigo_celular' => $alunonovo['Alunonovo']['codigo_celular'],
                        'celular' => $alunonovo['Alunonovo']['celular'],
                        'email' => $alunonovo['Alunonovo']['email'],
                        'cpf' => $alunonovo['Alunonovo']['cpf'],
                        'identidade' => $alunonovo['Alunonovo']['identidade'],
                        'orgao' => $alunonovo['Alunonovo']['orgao'],
                        'nascimento' => $alunonovo['Alunonovo']['nascimento'],
                        'endereco' => $alunonovo['Alunonovo']['endereco'],
                        'cep' => $alunonovo['Alunonovo']['cep'],
                        'municipio' => $alunonovo['Alunonovo']['municipio'],
                        'bairro' => $alunonovo['Alunonovo']['bairro'],
                        'observacoes' => $alunonovo['Alunonovo']['observacoes']
                ));
                // pr($cadastroaluno);
                // die();

                $this->loadModel('Aluno');
                $this->Aluno->set($cadastroaluno);
                if ($this->Aluno->save($cadastroaluno, array('validate' => TRUE))) {
                    $this->Session->setFlash('Registro do aluno novo inserido');
                    $aluno_id = $this->Aluno->getLastInsertId();
                } else {
                    $errors = $this->Aluno->invalidFields();
                    $this->Session->setFlash(implode(', ', $errors));
                    die('Error: Não foi possível inserir dados do aluno novo');
                }
            } else {
                echo "Aluno cadastrado: ";
                $aluno_id = $alunocadastrado['Aluno']['id'];
                // echo "aluno_id: " . $aluno_id;
                // die('626');
            }

            /*
             * Inserir estagiario para este periodo
             */
            $dados = array("Estagiario" => array(
                    'id_aluno' => $aluno_id,
                    'registro' => $this->data['Inscricao']['id_aluno'],
                    'nivel' => $this->data['Inscricao']['nivel'],
                    'turno' => $this->data['Inscricao']['turno'],
                    'tc' => '0',
                    'tc_solicitacao' => date('Y-m-d'),
                    'periodo' => $this->data['Inscricao']['periodo'],
                    'id_professor' => $id_prof,
                    'id_instituicao' => $this->data['Inscricao']['id_instituicao'],
                    'id_supervisor' => $this->data['Inscricao']['id_supervisor'],
                    'id_area' => $id_area,
            ));

            $this->Inscricao->Estagiario->set($dados);
            if ($this->Inscricao->Estagiario->save($dados, array('validate' => TRUE))) {
                $this->Session->setFlash('Registro de estágio inserido');
                $estagiario_id = $this->Inscricao->Estagiario->getlastInsertId();
                $this->redirect('/Inscricaos/termoimprime/' . $estagiario_id);
            } else {
                $errors = $this->Inscricao->Estagiario->invalidFields();
                $this->Session->setFlash(implode(',', $errors));
                die('Error: Não foi possível inserir dados de estágio');
            }
        }
    }

    /* id eh o numero de estagiario */

    public function termoimprime($id = NULL) {

        // echo "Estagiario id " . $id . "<br>";

        Configure::write('debug', 2);

        // $this->loadModel('Estagiario');
        $estagiario = $this->Inscricao->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id)
        ));
        // pr($estagiario);

        $instituicao_nome = $estagiario['Instituicao']['instituicao'];
        $supervisor_nome = $estagiario['Supervisor']['nome'];
        if (empty($supervisor_nome))
            $supervisor_nome = NULL;
        $aluno_nome = $estagiario['Aluno']['nome'];
        $nivel = $estagiario['Estagiario']['nivel'];
        $registro = $estagiario['Estagiario']['registro'];
        $supervisor_cress = $estagiario['Supervisor']['cress'];

        // pr($nivel);
        // die();
        // Capturo o inicio e o fim do termo de compromisso
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $termoinicio = $configuracao['Configuracao']['termo_compromisso_inicio'];
        $termofinal = $configuracao['Configuracao']['termo_compromisso_final'];

        $this->set('instituicao_nome', $instituicao_nome);
        $this->set('aluno_nome', $aluno_nome);
        $this->set('supervisor_nome', $supervisor_nome);
        $this->set('nivel', $nivel);
        $this->set('termoinicio', $termoinicio);
        $this->set('termofinal', $termofinal);
        $this->set('registro', $registro);
        $this->set('supervisor_cress', $supervisor_cress);
        // die();
        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

}

?>
