<?php

class InscricaosController extends AppController {

    var $name = "Inscricaos";
    var $components = array('Email');

    function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Acl->check($this->Session->read('user'), 'controllers', '*')) {
            $this->Auth->allowedActions = array('*');
            $this->Session->setFlash('Administrador');
            // echo "Tudo";
        // Estudantes podem fazer inscricao e solicitar termo de compromisso
        } elseif ($this->Acl->check($this->Session->read('user'), 'inscricaos', 'create')) {
            $this->Auth->allowedActions = array('add', 'inscricao', 'index', 'view', 'termosolicita', 'termocompromisso', 'termocadastra', 'termoimprime');
            $this->Session->setFlash('Estudante');
            // echo "Criar";
        // Professores e supervisores podem ver (index e view)
        } elseif ($this->Acl->check($this->Session->read('user'), 'inscricaos', 'read')) {
            $this->Auth->allowedActions = array('index', 'view');
            $this->Session->setFlash('Professor/Supervisor');
            // echo "Atualizar";
        } else {
            $this->Session->setFlash("Não autorizado");
        }
        // die(pr($this->Session->read('user')));
    }

/*
    function beforeFilter() {

        parent::beforeFilter();
        if ($this->Acl->check($this->Session->read('user'), 'inscricaos', 'add')) {
            $this->Auth->allowedActions = array('add', 'inscricao', 'index', 'view', 'termosolicita', 'termocompromisso', 'termocadastra', 'termoimprime');
            echo "Autorizado";
        } else {
            echo "Não autorizaado";
        }
        // die(pr($this->Session->read('user')));
    }
*/

    function index($id = NULL) {

        // Capturo o periodo atual de estagio para o mural
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['mural_periodo_atual'];

        if ($id) {
            $inscritos = $this->Inscricao->find('all',
                            array(
                                'conditions' => array('Inscricao.id_instituicao' => $id),
                                'fields' => array('Inscricao.id', 'Inscricao.id_aluno', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email', 'Mural.instituicao', 'Inscricao.id_instituicao'),
                                'order' => array('Aluno.nome' => 'asc')
                            )
            );
        } else {
            $inscritos = $this->Inscricao->find('all',
                            array(
                                'conditions' => array('Inscricao.periodo' => $periodo),
                                'fields' => array('Inscricao.id', 'Inscricao.id_aluno', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email'),
                                'group' => array('Inscricao.id_aluno'),
                                'order' => array('Aluno.nome' => 'asc')
                            )
            );
        }

        // pr($inscritos);
        // Junto todo num array para ordernar alfabeticamente
        $i = 0;
        foreach ($inscritos as $c_inscritos) {

            if (!empty($c_inscritos['Aluno']['nome'])) {
                $inscritos_ordem[$i]['nome'] = $c_inscritos['Aluno']['nome'];
                $inscritos_ordem[$i]['id'] = $c_inscritos['Aluno']['id'];
                $inscritos_ordem[$i]['id_inscricao'] = $c_inscritos['Inscricao']['id'];
                $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
				$inscritos_ordem[$i]['nascimento'] = $c_inscritos['Aluno']['nascimento'];
                $inscritos_ordem[$i]['telefone'] = $c_inscritos['Aluno']['telefone'];
                $inscritos_ordem[$i]['celular'] = $c_inscritos['Aluno']['celular'];
                $inscritos_ordem[$i]['email'] = $c_inscritos['Aluno']['email'];
                $inscritos_ordem[$i]['tipo'] = 1; // Estagiario
            } else {
                $inscritos_ordem[$i]['nome'] = $c_inscritos['Alunonovo']['nome'];
                $inscritos_ordem[$i]['id'] = $c_inscritos['Alunonovo']['id'];
                $inscritos_ordem[$i]['id_inscricao'] = $c_inscritos['Inscricao']['id'];
                $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
				$inscritos_ordem[$i]['nascimento'] = $c_inscritos['Alunonovo']['nascimento'];
                $inscritos_ordem[$i]['telefone'] = $c_inscritos['Alunonovo']['telefone'];
                $inscritos_ordem[$i]['celular'] = $c_inscritos['Alunonovo']['celular'];
                $inscritos_ordem[$i]['email'] = $c_inscritos['Alunonovo']['email'];
                $inscritos_ordem[$i]['tipo'] = 0; // Novo
            }
            $i++;
        }
        asort($inscritos_ordem);

        /* Conta a quantidade de alunos novos e estagiarios */
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
        // echo "Estagiarios: " . $alunos_estagiarios . " Novos: " . $alunos_novos;
        /* Fim da conta da quantidade de alunos novos e estagiarios */

        // pr($inscritos[0]['Mural']['instituicao']);
		if (isset($inscritos[0]['Mural']['instituicao'])) {
        	$this->set('instituicao', $inscritos[0]['Mural']['instituicao']);
		}
		if (isset($inscritos[0]['Inscricao']['id_instituicao'])) {
        	$this->set('mural_id', $inscritos[0]['Inscricao']['id_instituicao']);
		}
        $this->set('inscritos', $inscritos_ordem);
    }

    function add($id = NUL) {

        // pr($this->data);
        $this->set('id_instituicao', $id);

        // Verifico se foi preenchido o numero de registro
        if (isset($this->data['Inscricao']['id_aluno'])) {

            /* Verificacoes */
            // Verifico se ja esta em estagio. Se está atualiza
            $this->loadModel('Aluno');
            $registro = $this->data['Inscricao']['id_aluno'];
            $aluno = $this->Aluno->findByRegistro($registro, array('fields' => 'id', 'registro'));
            if ($aluno) {
                echo "Aluno estagiario";
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
                    echo "Aluno novo nao cadastrado";
                    // Redireciono com um cookie para lembrar a origem do redirecionamento
                    $this->Session->delete('id_instituicao', $id);
                    $this->Session->write('id_instituicao', $id);
                    $this->redirect('/Alunonovos/add/' . $registro);
                    // die();
                    // Se esta cadastrado como alunonovo redireciona para /Alunonovos/edit
                } else {
                    echo "Aluno novo cadastrado";
                    // Redireciono com um cookie para lembrar a origem do redirecionamento
                    $this->Session->delete('id_instituicao', $id);
                    $this->Session->write('id_instituicao', $id);
                    $this->redirect('/Alunonovos/edit/' . $alunonovo['Alunonovo']['id']);
                }
            }
            /* Fim das verificacoes */
        }
    }

    // Id e o numero de registro
    function inscricao($id = NULL) {

        // echo "Id: " . $id . "<br>";
        // die();
        if ($id) {
            // Capturo o id da instituicao de inscricao para selecao de estagio (vem tanto de aluno como de alunonvo)
            $id_instituicao = $this->Session->read('id_instituicao');
            // Agora sim posso apagar
            $this->Session->delete('id_instituicao');

            $this->loadModel('Mural');
            $instituicao = $this->Mural->findById($id_instituicao, array('fields' => 'periodo'));
            $periodo = $instituicao['Mural']['periodo'];

            $this->data['Inscricao']['periodo'] = $periodo;
            $this->data['Inscricao']['id_instituicao'] = $id_instituicao;
            $this->data['Inscricao']['data'] = date('Y-m-d');
            $this->data['Inscricao']['id_aluno'] = $id;

            if ($this->Inscricao->save($this->data)) {
                // pr($this->data);
                $this->Session->setFlash("Inscrição realizada");
                $this->redirect('/Inscricaos/index/' . $id_instituicao);
            }
        }
    }

    function view($id = NULL) {
    	
        $inscricao = $this->Inscricao->findById($id);
        $this->set('inscricao', $inscricao);
    }

    function edit($id = NULL) {

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

    function delete($id = NULL) {

        $instituicao = $this->Inscricao->findById($id, array('fiedls' => 'id_instituicao'));
        $this->Inscricao->delete($id);
        $this->Session->setFlash("Inscrição excluída");
        $this->redirect('/Inscricaos/index/' . $instituicao['Inscricao']['id_instituicao']);

    }

    function emailparainstituicao($id = NULL) {

        if ($id) {
            $inscritos = $this->Inscricao->find('all',
                            array(
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

            asort($inscritos_ordem);

            if ($inscritos[0]['Mural']['email']) {
                $this->Email->smtpOptions = array(
                    'port' => '465',
                    'timeout' => '30',
                    'host' => 'ssl://smtp.gmail.com',
                    'username' => 'estagio.ess',
                    'password' => 'essufrjestagio',
                );
                /* Set delivery method */
                $this->Email->delivery = 'smtp';
                // $this->Email->to = $user['email'];
                $this->Email->to = 'uy_luis@hotmail.com'; // $incritos[0]['Mural']['email']
                $this->Email->subject = 'ESS/UFRJ: Estudantes inscritos para seleção de estágio';
                $this->Email->replyTo = '"Coordenação de Estágio e Extensão" <estagio@ess.ufrj.br>';
                $this->Email->from = '"Coordenação de Estágio e Extensão" <estagio.ess@gmail.com>';
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
            } else {
                $this->Session->setFlash('Imposível enviar email (falta o endereço)');
                $this->redirect('/Murals/view/' . $inscritos[0]['Mural']['id']);
            }
        }
    }

    // Captura o registro digitado pelo estudante
    function termosolicita($id = NULL) {

        if ($this->data) {
            // pr($this->data);
            $registro = $this->data['Inscricao']['id_aluno'];
            $this->redirect('/Inscricaos/termocompromisso/' . $registro);
        }
    }

    // Com o numero de registro busco as informacoes em estagiario ou alunonovo
    // Se nao esta cadastrado em alunonovo faço o cadastramento
    // Se nao eh estagiario eh um alunonovo entao faço cadastramento
    function termocompromisso($id = NULL) {

        // Captura o periodo de estagio para o termo de compromisso
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

        // pr($this->data);
        // Busca em estagiarios o ultimo estagio do aluno
        $this->loadModel('Estagiario');
        $estagiario = $this->Estagiario->find('first', array(
                    'conditions' => array('Estagiario.registro' => $id),
                    'fields' => array('Estagiario.id', 'Estagiario.periodo', 'Estagiario.turno', 'Estagiario.id_aluno', 'Estagiario.registro', 'Estagiario.nivel', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_professor', 'Aluno.id', 'Aluno.registro', 'Aluno.nome'),
                    'order' => array('periodo' => 'DESC')
                        )
        );
        // pr($estagiario);
        // Aluno estagiario
        if ($estagiario) {
            echo "Aluno estagiario" . "<br />";

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
            // pr($alunonovo);
            // die();
            // Aluno novo nao cadastrado: vai para cadastro e retorna
            if (empty($alunonovo)) {
                $this->Session->setFlash("Aluno não cadastrado");
                $this->Session->write('termo', $id);
                $this->redirect('/Alunonovos/add/' . $id);
                die('Redireciona para cadastro de alunos novos');
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

    function termocadastra($id = NULL) {

        // Configure::write('debug', '2');
        // echo "id " . $id . "<br>";
        // pr($this->data);
        // die('386');
        // Se ja esta como estagiario pego o id para atualizar
        $this->loadModel("Estagiario");
        $periodo_estagio = $this->Estagiario->find('first', array(
                    'conditions' => array('Estagiario.periodo' => $this->data['Inscricao']['periodo'], 'Estagiario.registro' => $this->data['Inscricao']['id_aluno']),
                    'fields' => array('Estagiario.id', 'Estagiario.id_aluno')));
        // pr($periodo_estagio);
        // die('394');
        /* Capturo os valores da area e professor da instituicao selecionada
         * Estes valores foram capturados no controller Instituicao funcao seleciona_supervisor
         */
        $id_area = $this->Session->read('id_area');
        $id_prof = $this->Session->read('id_prof');
        // Apago os cookies que foram passados na sessao
        $this->Session->delete('id_area');
        $this->Session->delete('id_prof');
        // echo $id_area . " " . $id_prof . "<br>";
        // die('407');
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

            $this->Estagiario->set($dados);
            if ($this->Estagiario->save($dados, array('validate' => TRUE))) {
                $this->Session->setFlash('Registro de estágio atualizado');
                $this->redirect('/Inscricaos/termoimprime/' . $id_estagio);
            } else {
                $errors = $this->Estagiario->invalidFields();
                $this->Session->setFlash(implode(',', $errors));
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
                echo "Aluno nao cadastrado";
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
                    $this->Session->setFlash(implode(',', $errors));
                    die('Error: Não foi possível inserir dados do aluno novo');
                }
            } else {
                echo "Aluno cadastrado: ";
                $aluno_id = $alunocadastrado['Aluno']['id'];
                // echo "aluno_id: " . $aluno_id;
                // die('497');
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

            $this->Estagiario->set($dados);
            if ($this->Estagiario->save($dados, array('validate' => TRUE))) {
                $this->Session->setFlash('Registro de estágio inserido');
                $estagiario_id = $this->Estagiario->getlastInsertId();
                $this->redirect('/Inscricaos/termoimprime/' . $estagiario_id);
            } else {
                $errors = $this->Estagiario->invalidFields();
                $this->Session->setFlash(implode(',', $errors));
                die('Error: Não foi possível inserir dados de estágio');
            }
        }
    }

    /* id eh o numero de estagiario */

    function termoimprime($id = NULL) {

        // echo "Estagiario id " . $id . "<br>";

        Configure::write('debug', 2);

        $this->loadModel('Estagiario');
        $estagiario = $this->Estagiario->find('first', array(
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

        /*
          $id_instituicao = $this->data['Inscricao']['id_instituicao'];
          if (empty($id_instituicao)) {
          $this->Session->setFlash('Selecione a instituição');
          // $this->redirect('/Inscricaos/termocompromisso/' . $id);
          die('Instituicao nao foi selecionada');
          } else {
          $this->loadModel('Instituicao');
          if (!empty($id_instituicao)) {
          $instituicao_nome = $this->Instituicao->findById($id_instituicao, array('fields' => 'instituicao'));
          // pr($instituicao_nome);
          }
          }

          $id_supervisor = $this->data['Inscricao']['id_supervisor'];
          $this->loadModel('Supervisor');
          if (!empty($id_supervisor)) {
          $supervisor_nome = $this->Supervisor->findById($id_supervisor, array('fields' => 'nome', 'cress'));
          // pr($supervisor_nome);
          } else {
          $supervisor_nome = NULL;
          }
         */
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

        $this->layout = "pdf";
        $this->render();
    }

}

?>
