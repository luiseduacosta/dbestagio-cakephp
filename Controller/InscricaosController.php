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

        $ordem = isset($_REQUEST['ordem']) ? $_REQUEST['ordem'] : "nome";
        // echo "Ordem: " . $ordem;
        // die();
        // Capturo o periodo de estagio para o mural
        $periodo = $this->Session->read('mural_periodo');
        if (!$periodo) {
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
        }
        // echo "Período: " . $periodo;
        // die();
        // echo "Id: " . $id;
        // die();

        if ($id) {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.mural_estagio_id' => $id),
                'fields' => array('Inscricao.id', 'Inscricao.aluno_id', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Estagiario.id', 'Estagiario.periodo', 'Estagiario.instituicao_id', 'Mural.id_estagio', 'Mural.vagas', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email', 'Mural.instituicao', 'Inscricao.mural_estagio_id'),
                'order' => array('Aluno.nome' => 'asc'),
                    )
            );
            // pr($inscritos);
            // die();
            if ($inscritos) {
                $vagas = $inscritos[0]['Mural']['vagas'];
                // pr($inscritos[0]['Mural']['vagas']);
                $instituicao_id = $inscritos[0]['Mural']['id_estagio'];
            }            
        } else {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.periodo' => $periodo),
                'fields' => array('Inscricao.id', 'Inscricao.aluno_id', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email'),
                /* 'group' => array('Inscricao.id_aluno'), */
                'order' => array('Aluno.nome' => 'asc')
                    )
            );
        }
        // pr($inscritos);
        // die();
        
        // Somente se há inscritos e a consulta tem origem numa instituição
        if ($inscritos) {
            // pr($inscritos);
            // Junto todo num array para ordernar alfabeticamente
            $i = 0;
            foreach ($inscritos as $c_inscritos) {

                if (!empty($c_inscritos['Aluno']['nome'])) {
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Aluno']['nome'];
                    $inscritos_ordem[$i]['id'] = $c_inscritos['Aluno']['id'];
                    $inscritos_ordem[$i]['id_inscricao'] = $c_inscritos['Inscricao']['id'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['aluno_id'];

                    // print_r($c_inscritos['Aluno']['nascimento']);
                    if (!is_null($c_inscritos['Aluno']['nascimento'])) {
                        $inscritos_ordem[$i]['nascimento'] = $c_inscritos['Aluno']['nascimento'];
                    } else {
                        $inscritos_ordem[$i]['nascimento'] = 's/d';
                    }
                    // print_r($inscritos_ordem[$i]['nascimento']);
                    // echo "<br>";

                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Aluno']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Aluno']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Aluno']['email'];
                    $inscritos_ordem[$i]['tipo'] = 1; // Estagiario
                    // Estudante estagio no campo que fez selecao de estagio
                    // if ($c_inscritos['Estagiario']['instituicao_id'] === $c_inscritos['Mural']['id_estagio']) {
                    // echo $c_inscritos['Estagiario']['instituicao_id'] . " " . $c_inscritos['Mural']['id_estagio'];
                    // $inscritos_ordem[$i]['selecao_mural'] = $c_inscritos['Estagiario']['periodo'];
                    // die("Estagio no Mural");
                    // }
                    // Para ordenar o array
                    $criterio[] = $inscritos_ordem[$i][$ordem];
                } else {
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Alunonovo']['nome'];
                    $inscritos_ordem[$i]['id'] = $c_inscritos['Alunonovo']['id'];
                    $inscritos_ordem[$i]['id_inscricao'] = $c_inscritos['Inscricao']['id'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['aluno_id'];

                    // print_r($c_inscritos['Inscricao']['id_aluno']);
                    // echo ": ";
                    // print_r($c_inscritos['Alunonovo']['nascimento']);
                    if (!is_null($c_inscritos['Alunonovo']['nascimento'])) {
                        $inscritos_ordem[$i]['nascimento'] = $c_inscritos['Alunonovo']['nascimento'];
                    } else {
                        $inscritos_ordem[$i]['nascimento'] = 's/d';
                    }
                    // print_r($inscritos_ordem[$i]['nascimento']);
                    // echo "<br>";

                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Alunonovo']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Alunonovo']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Alunonovo']['email'];
                    $inscritos_ordem[$i]['tipo'] = 0; // Novo
                    // Para ordenar o array
                    $criterio[] = $inscritos_ordem[$i][$ordem];
                }
                $i++;
            }

            if (isset($criterio))
                array_multisort($criterio, SORT_ASC, $inscritos_ordem);

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
            if (isset($inscritos[0]['Inscricao']['mural_estagio_id'])) {
                $this->set('mural_id', $inscritos[0]['Inscricao']['mural_estagio_id']);
            }

            // pr($instituicao_id);
            if (isset($instituicao_id) && !empty($instituicao_id)):
                $estagiarios = $this->Inscricao->Estagiario->find('first', array(
                    'fields' => array("count('Estagiario.id') as estagiarios"),
                    'conditions' => array('Estagiario.instituicao_id' => $instituicao_id,
                        'Estagiario.periodo' => $periodo)
                ));
            endif;
            // pr($estagiarios);
            // die();

            $this->set('periodo', $periodo);
            if (isset($vagas)) {
                $this->set('vagas', $vagas);
            }
            if (isset($estagiarios[0]['estagiarios'])):
                $this->set('estagiarios', $estagiarios[0]['estagiarios']);
            endif;
            if (isset($instituicao_id)):
                $this->set('instituicao_id', $instituicao_id);
            endif;
            $this->set('inscritos', $inscritos_ordem);
        }
    }

    public function orfao() {

        $this->loadModel("Alunonovo");
        $this->set('orfaos', $this->Alunonovo->alunonovorfao());
    }

    public function add($id = NUL) {

        // pr($this->data);
        $this->set('instituicao_id', $id);

        // Verifico se foi preenchido o numero de registro
        if (isset($this->data['Inscricao']['aluno_id'])) {

            /* Verificacoes */
            if ((strlen($this->request->data['Inscricao']['aluno_id'])) < 9) {
                $this->Session->setFlash("Registro incorreto");
                $this->redirect('/Inscricaos/add/');
                die("Registro incorreto");
                exit;
            }
            // Verifico se ja esta em estagio. Se está atualiza
            $this->loadModel('Aluno');
            $registro = $this->data['Inscricao']['aluno_id'];
            $aluno = $this->Aluno->findByRegistro($registro, array('fields' => 'id', 'registro'));
            if ($aluno) {
                // echo "Aluno estagiario";
                $this->Session->delete('instituicao_id', $id);
                $this->Session->write('instituicao_id', $id);
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
                    $this->Session->delete('instituicao_id', $id);
                    $this->Session->write('instituicao_id', $id);
                    $this->redirect('/Alunonovos/add/' . $registro);
                    // die();
                    // Se esta cadastrado como alunonovo redireciona para /Alunonovos/edit
                } else {
                    // echo "Aluno novo cadastrado!";
                    // Redireciono com um cookie para lembrar a origem do redirecionamento
                    $this->Session->delete('instituicao_id', $id);
                    $this->Session->write('instituicao_id', $id);
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
            $instituicao_id = $this->Session->read('instituicao_id');
            // echo "Instituicao: " . $instituicao_id;
            // die();
            // Agora sim posso apagar
            $this->Session->delete('instituicao_id');

            /* Capturo o periodo para o registro de inscricao */
            $this->loadModel('Mural');
            $instituicao = $this->Mural->findById($instituicao_id, array('fields' => 'periodo'));
            $periodo = $instituicao['Mural']['periodo'];
            // echo "Período: " . $periodo;
            // die();

            /* Carrego o array de inscrição com os valores */
            $this->request->data['Inscricao']['periodo'] = $periodo;
            $this->request->data['Inscricao']['mural_estagio_id'] = $instituicao_id;
            $this->request->data['Inscricao']['data'] = date('Y-m-d');
            $this->request->data['Inscricao']['aluno_id'] = $id;

            // debug($this->data);
            // pr($this->data);
            // die();

            if ($this->Inscricao->save($this->request->data)) {
                $this->Session->setFlash("Inscrição realizada");
                $this->redirect('/Inscricaos/index/' . $instituicao_id);
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

        $instituicao = $this->Inscricao->findById($id, array('fields' => 'mural_estagio_id'));
        $this->Inscricao->delete($id);
        $this->Session->setFlash("Inscrição excluída");
        $this->redirect('/Inscricaos/index/' . $instituicao['Inscricao']['instituicao_id']);
    }

    public function emailparainstituicao($id = NULL) {

        if ($id) {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.instituicao_id' => $id),
                'fields' => array('Aluno.nome', 'Inscricao.id', 'Inscricao.id_aluno', 'Aluno.celular', 'Aluno.telefone', 'Aluno.email', 'Alunonovo.nome', 'Alunonovo.celular', 'Alunonovo.telefone', 'Alunonovo.email', 'Mural.id', 'Mural.instituicao', 'Mural.email', 'Inscricao.instituicao_id'),
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
            $registro = $this->request->data['Inscricao']['aluno_id'];
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
            'fields' => array('Estagiario.id', 'Estagiario.periodo', 'Estagiario.turno', 'Estagiario.aluno_id', 'Estagiario.registro', 'Estagiario.nivel', 'Estagiario.instituicao_id', 'Estagiario.supervisor_id', 'Estagiario.docente_id', 'Aluno.id', 'Aluno.registro', 'Aluno.nome'),
            'order' => array('periodo' => 'DESC')
                )
        );
// $log = $this->inscricao->Estagiario->getDataSource()->getLog(false, false);
// debug($log);

        // pr($estagiario);
        // die("termocompromisso");
        // Se o aluno estagiario eh estagiario
        if ($estagiario) {
            // echo "Aluno estagiario" . "<br />";
            // pr($estagiario);
            $periodo_ultimo = $estagiario['Estagiario']['periodo'];
            $nivel_ultimo = $estagiario['Estagiario']['nivel'];
            $turno_ultimo = $estagiario['Estagiario']['turno'];
            $instituicao_atual = $estagiario['Estagiario']['instituicao_id'];
            $supervisor_atual = $estagiario['Estagiario']['supervisor_id'];
            $professor_atual = $estagiario['Estagiario']['docente_id'];
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
            'conditions' => array('Estagiario.periodo' => $this->data['Inscricao']['periodo'], 'Estagiario.registro' => $this->data['Inscricao']['aluno_id']),
            'fields' => array('Estagiario.id', 'Estagiario.aluno_id')));
        // pr($periodo_estagio);
        // die('539');
        /* Capturo os valores da area e professor da instituicao selecionada
         * Estes valores foram capturados no controller Instituicao funcao seleciona_supervisor
         */
        $id_area = $this->Session->read('id_area');
        $id_prof = $this->Session->read('id_prof');
        // Apago os cookies que foram passados na sessao
        $this->Session->delete('id_area');
        $this->Session->delete('id_prof');
        // echo $id_area . " " . $id_prof . "<br>";
        // die('549');
        // Tem que ter o id da instituicao diferente de zero
        if (empty($this->data['Inscricao']['instituicao_id'])) {
            $this->Session->setFlash('Selecione uma instituição de estágio');
            $this->redirect('/Inscricaos/termosolicita/');
            die('Faltou selecionar uma instituição');
        }
        // pr($this->data);
        // die('557');
        // Estagio ja cadastrado: atualizacao.
        if ($periodo_estagio) {
            $id_estagio = $periodo_estagio['Estagiario']['id'];
            $aluno_id = $periodo_estagio['Estagiario']['aluno_id'];

            $dados = array("Estagiario" => array(
                    'id' => $id_estagio,
                    'id_aluno' => $id_aluno,
                    'registro' => $this->data['Inscricao']['aluno_id'],
                    'nivel' => $this->data['Inscricao']['nivel'],
                    'turno' => $this->data['Inscricao']['turno'],
                    'tc' => '0',
                    'tc_solicitacao' => date('Y-m-d'),
                    'periodo' => $this->data['Inscricao']['periodo'],
                    'docente_id' => $id_prof,
                    'instituicao_id' => $this->data['Inscricao']['instituicao_id'],
                    'supervisor_id' => $this->data['Inscricao']['supervisor_id'],
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
                 * Pode ser desnecessário se houver uma única tabela de estudantes
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
                    'registro' => $this->data['Inscricao']['aluno_id'],
                    'nivel' => $this->data['Inscricao']['nivel'],
                    'turno' => $this->data['Inscricao']['turno'],
                    'tc' => '0',
                    'tc_solicitacao' => date('Y-m-d'),
                    'periodo' => $this->data['Inscricao']['periodo'],
                    'professor_id' => $id_prof,
                    'instituicao_id' => $this->data['Inscricao']['instituicao_id'],
                    'supervisor_id' => $this->data['Inscricao']['supervisor_id'],
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

        Configure::write('debug', 0);

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
