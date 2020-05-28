<?php

class InscricoesController extends AppController {

    public $name = "Inscricoes";
    public $components = array('Email', 'Auth');
    public $paginate = [
        'limit' => 25,
        'order' => ['Inscricao.aluno_id']
    ];

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'add', 'inscricao', 'delete', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('index', 'view', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash(_("Não autorizado"));
            $this->redirect('/Userestagios/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index($id = NULL) {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $mural_estagio_id = isset($parametros['mural_estagio_id']) ? $parametros['mural_estagio_id'] : NULL;
        $ordem = isset($_REQUEST['ordem']) ? $_REQUEST['ordem'] : "nome";

        // Capturo o periodo de estagio para o mural
        if (!$periodo) {
            $periodo = $this->Session->read('mural_periodo');
            if (!$periodo) {
                $this->loadModel("Configuracao");
                $configuracao = $this->Configuracao->findById('1');
                $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
            }
        }
        // echo "Período: " . $periodo;
        // die();

        if (!$id) {
            $id = $mural_estagio_id;
        }
        // echo "Id: " . $id;
        // die('id');

        if ($id) {
            $inscritos = $this->Inscricao->alunosestudantesmural($id);
            // $log = $this->Inscricao->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($inscritos);
            // die('inscritos');
            if ($inscritos) {
                $vagas = $inscritos[0]['Muralestagio']['vagas'];
                $instituicao_id = $inscritos[0]['Muralestagio']['id_estagio'];
                $mural_estagio_id = $inscritos[0]['Inscricao']['mural_estagio_id'];
                $instituicao = $inscritos[0]['Muralestagio']['instituicao'];
                // pr($inscritos[0]['Muralestagio']['vagas']);
                // pr($instituicao_id);
                // die();
            }
            // die('id');
        } else {
            $inscritos = $this->Inscricao->alunosestudantesperiodo($periodo);
        }
        // pr($inscritos);
        // die('inscricoes');
        // Somente se há inscritos e a consulta tem origem numa instituição
        if ($inscritos) {
            // pr($inscritos);
            // Junto todo num array para ordernar alfabeticamente
            $i = 0;
            $alunos_estagiarios = 0;
            $alunos_novos = 0;
            foreach ($inscritos as $c_inscritos) {
                // pr($c_inscritos);
                // echo $vagas;
                // die('vagas');
                $inscritos_ordem[$i]['nome'] = $c_inscritos['Estudante']['nome'];
                $inscritos_ordem[$i]['estudante_id'] = $c_inscritos['Estudante']['id'];
                /*  Conta a quantidade de inscrições por estudante no período */
                $inscricoesporestudante = $this->Inscricao->find('all', [
                    'fields' => ['count(Inscricao.aluno_id) as q_inscricaoporestudante'],
                    'conditions' => ['Inscricao.aluno_id' => $c_inscritos['Estudante']['registro'],
                        ['Inscricao.periodo' => $periodo]]
                ]);
                // pr($inscricoesporestudante);
                // die('inscricoesporestudante');
                $inscritos_ordem[$i]['q_inscricoes'] = $inscricoesporestudante[0][0]['q_inscricaoporestudante'];
                $inscritos_ordem[$i]['inscricao_id'] = $c_inscritos['Inscricao']['id'];
                $inscritos_ordem[$i]['registro'] = $c_inscritos['Inscricao']['aluno_id'];
                $inscritos_ordem[$i]['periodo'] = $c_inscritos['Inscricao']['periodo'];

                if (!is_null($c_inscritos['Estudante']['nascimento'])) {
                    $inscritos_ordem[$i]['nascimento'] = $c_inscritos['Estudante']['nascimento'];
                } else {
                    $inscritos_ordem[$i]['nascimento'] = 's/d';
                }

                $inscritos_ordem[$i]['telefone'] = $c_inscritos['Estudante']['telefone'];
                $inscritos_ordem[$i]['celular'] = $c_inscritos['Estudante']['celular'];
                $inscritos_ordem[$i]['email'] = $c_inscritos['Estudante']['email'];
                $this->loadModel('Estagiario');
                $estagiario = $this->Estagiario->find('first', [
                    'conditions' => ['Estagiario.registro' => $c_inscritos['Estudante']['registro']]
                ]);
                // pr($estagiario);
                // die('estagiario');
                if (isset($estagiario['Estagiario']['id'])) {
                    $inscritos_ordem[$i]['tipo'] = 1; // Estagiario
                    $alunos_estagiarios++;
                } else {
                    $inscritos_ordem[$i]['tipo'] = 0; // Novo
                    $alunos_novos++;
                }
                $i++;
            }
            array_multisort(array_column($inscritos_ordem, $ordem), SORT_ASC, $inscritos_ordem);
        }
        // pr($inscritos_ordem);
        // die('inscricao_ordem');
        // Descrimino pela variavel Tipo os estagiários: 0 => Sem estágio, 1 => Com estágio
        // pr(array_count_values(array_column($inscritos_ordem, 'tipo')));
        $estudantetipos = array_count_values(array_column($inscritos_ordem, 'tipo'));
        // echo $estudantestipos[0] . " " . $estudantestipos[1] . "<br />";
        $estudanteregistros = array_count_values(array_column($inscritos_ordem, 'registro'));
        // pr($estudanteregistros);
        // pr($criterio);
        // die('inscritos_ordem');
        $this->set('estudantetipos', $estudantetipos);
        $this->set('mural_estagio_id', $id);
        $this->set('periodo', $periodo);
        if (isset($vagas)) {
            $this->set('vagas', $vagas);
        }
        if (isset($instituicao_id)):
            $this->set('instituicao_id', $instituicao_id);
        endif;
        if (isset($instituicao)) {
            $this->set('instituicao', $instituicao);
        }
        $this->set('inscritos', $inscritos_ordem);
    }

    public function orfao() {

        $this->loadModel("Estudante");
        $this->set('orfaos', $this->Estudante->alunonovorfao());
    }

    public function add($id = NULL) {

        $parametros = $this->params['named'];
        $registro = isset($parametros['registro']) ? $parametros['registro'] : null;
        $mural_estagio_id = isset($parametros['mural_estagio_id']) ? $parametros['mural_estagio_id'] : null;

        $this->set('mural_estagio_id', $mural_estagio_id);

        // Verifico se foi preenchido o numero de registro
        if (isset($this->request->data['aluno_id'])) {
            // pr($this->request->data);
            // die();
            /* Verificacoes */
            if ((strlen($this->request->data['Inscricao']['aluno_id'])) < 9) {
                $this->Session->setFlash(__("Número de registro incorreto?"));
                $this->redirect('/Inscricoes/add/');
                die("Registro incorreto");
                exit;
            }
        }
    }

    /*
     * Inscreve o aluno para seleção de estágio
     * O Id e o numero de registro
     * @PARAMETROS $registro ou $aluno_id e $mural_estagio_id
     *
     * @RETURN true ou false
     *
     */

    public function inscricao($id = NULL) {

        $parametros = $this->params['named'];
        $mural_estagio_id = isset($parametros['mural_estagio_id']) ? $parametros['mural_estagio_id'] : NULL;
        $registro = isset($parametros['registro']) ? $parametros['registro'] : NULL;
        // pr($mural_estagio_id);
        // pr($registro);
        // die('inscricao');

        /* O registro do Estudante deve coincidir com o registro do login
         */
        $registrologin = $this->Session->read('numero');
        if ($registro != $registrologin) {
            if ($this->Session->read('id_categoria') === '2') {
                $this->Session->setFlash(__('Realize login com seu número de DRE'));
                $this->redirect('/Userestagios/login');
            }
        }

        // pr($mural_estagio_id);
        // die('mural_estagio_id');

        /*
         * Verifica se já fez inscrição para esta seleção de estágio
         */
        $selecaoestagio = $this->Inscricao->find('first', [
            'conditions' => ['Inscricao.aluno_id' => $this->request->data['Inscricao']['aluno_id'],
                'Inscricao.mural_estagio_id' => $this->request->data['Inscricao']['mural_estagio_id']]
        ]);
        /*
         * Se já fez mostra a Inscricao/view
         */
        if ($selecaoestagio) {
            $this->Session->setFlash(__('Inscrição para seleção de estágio já realizada'));
            $this->redirect('/Inscricoes/view/' . $selecaoestagio['Inscricao']['id']);
            /*
             * Se não fez leva para Estudante/view para atualizar seus dados
             */
        } else {

            /* Capturo o periodo para o registro de inscricao */
            $this->loadModel('Muralestagio');
            $periodo_mural_estagio = $this->Muralestagio->find('first', [
                'conditiones' => ['Murelestagio.id' => $mural_estagio_id],
                'fields' => ['periodo']]);
            $periodo = $periodo_mural_estagio['Muralestagio']['periodo'];
            // echo "Período: " . $periodo;
            // die('periodo');

            /* Carrego o array de inscrição com os valores */
            $this->request->data['Inscricao']['periodo'] = $periodo;
            $this->request->data['Inscricao']['mural_estagio_id'] = $mural_estagio_id;
            $this->request->data['Inscricao']['data'] = date('Y-m-d');
            $this->request->data['Inscricao']['aluno_id'] = $registro;

            // debug($this->data);
            // pr($this->data);
            // die();

            if ($this->Inscricao->save($this->request->data)) {
                $this->Session->setFlash(__("Inscrição realizada"));
                // $this->redirect('/Inscricoes/index/' . $instituicao_id);
                $this->redirect('/Inscricoes/view/' . $this->Inscricao->id);
            }
        }
    }

    public function view($id = NULL) {

        /* Busca entre Estudantes, Inscricoes e Muralestagio com o $id da Inscricao */
        $alunosestudantesinscritos = $this->Inscricao->alunosestudantesinscritos($id);
        $this->set('inscricao', $alunosestudantesinscritos);
    }

    public function edit($id = NULL) {

        $this->Inscricao->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Inscricao->read();
        } else {
            if ($this->Inscricao->save($this->data)) {
                $this->Session->setFlash("Inscrição atualizada");
                $this->redirect('/Inscricoes/view/' . $this->Inscricao->id);
            }
        }
    }

    public function delete($id = NULL) {

        $muralestagio = $this->Inscricao->findById($id, array('fields' => 'mural_estagio_id'));
        $this->Inscricao->delete($id);
        $this->Session->setFlash(__("Inscrição excluída"));
        $this->redirect('/Inscricoes/index/' . $muralestagio['Inscricao']['mural_estagio_id']);
    }

    public function emailparainstituicao($id = NULL) {

        if ($id) {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.instituicao_id' => $id),
                'fields' => array('Inscricao.id', 'Inscricao.aluno_id', 'Estudante.nome', 'Estudante.celular', 'Estudante.telefone', 'Estudante.email', 'Muralestagio.id', 'Muralestagio.instituicao', 'Muralestagio.email', 'Inscricao.instituicao_id'),
                'order' => array('Estudante.nome' => 'asc')
                    )
            );
            // pr($inscritos);

            $i = 0;
            foreach ($inscritos as $c_inscritos) {

                $inscritos_ordem[$i]['nome'] = $c_inscritos['Estudante']['nome'];
                $inscritos_ordem[$i]['aluno_id'] = $c_inscritos['Inscricao']['aluno_id'];
                $inscritos_ordem[$i]['telefone'] = $c_inscritos['Estudante']['telefone'];
                $inscritos_ordem[$i]['celular'] = $c_inscritos['Estudante']['celular'];
                $inscritos_ordem[$i]['email'] = $c_inscritos['Estudante']['email'];
                $criterio[$i]['nome'] = $c_inscritos['Estudante']['nome'];

                $i++;
            }

            if (isset($inscritos_ordem)) {

                asort($inscritos_ordem);

                if ($inscritos[0]['Muralestagio']['email']) {
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
                    // $this->Email->to = 'uy_luis@hotmail.com'; // $incritos[0]['Muralestagio']['email']
                    $this->Email->to = $inscritos[0]['Muralestagio']['email'];
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
                    $this->loadModel("Muralestagio");
                    $this->Muralestagio->id = $inscritos[0]['Muralestagio']['id'];
                    $this->Muralestagio->savefield('datafax', date('Y-m-d'));

                    $this->Session->setFlash('Email enviado');
                    $this->redirect('/Muralestagios/view/' . $inscritos[0]['Muralestagio']['id']);
                }
            } else {

                $this->Session->setFlash(__('Imposível enviar email (falta o endereço)'));
                $this->redirect('/Muralestagios/view/' . $inscritos[0]['Muralestagio']['id']);
            }
        }
    }

    /*
     * Captura o registro digitado pelo estudante
     * Parece ser uma função desnecessária:
     * recebe como parámetro o registro e retorna o mesmo registro
     * 
     * @PARAM $id registro do estudante
     * 
     * @RETURN $registro o mesmo registro
     * 
     */

    public function termosolicita($id = null) {

        if ($this->request->data) {
            // pr($this->request->data);
            $registro = $this->request->data['Inscricao']['aluno_id'];
            // pr($registro);
            // die("termosoliciata");
            $this->redirect('/Inscricoes/termocompromisso/' . $registro);
        }
    }

    // Com o numero de registro busco as informacoes em estagiario ou estudante
    // Se nao esta cadastrado em estudante faço o cadastramento
    // Se nao eh estagiario eh um estudante entao faço cadastramento
    public function termocompromisso($id = NULL) {

        // Captura o periodo de estagio para o termo de compromisso
        // pr($id);
        // die("termocompromisso ");
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];
        // die("configuração");

        /*
         *  Busca em estagiarios o ultimo estagio do aluno
         */
        $this->loadModel('Estudante');
        $estagiario = $this->Estudante->query('SELECT * FROM  estudantes AS Estudante '
                . ' LEFT JOIN estagiarios AS Estagiario ON Estudante.registro = Estagiario.registro '
                . ' WHERE Estudante.registro = ' . $id
                . ' ORDER BY Estagiario.nivel DESC'
                . ' LIMIT 1');
        // pr($estagiario);
        /*
         *  Se retorna um valor quer dizer que eh estagiario
         */
        if ($estagiario[0]) {
            // echo "Aluno estagiario" . "<br />";
            // pr($estagiario);
            $periodo_ultimo = $estagiario[0]['Estagiario']['periodo'];
            $nivel_ultimo = $estagiario[0]['Estagiario']['nivel'];
            $turno_ultimo = $estagiario[0]['Estagiario']['turno'];
            $instituicao_atual = $estagiario[0]['Estagiario']['instituicao_id'];
            $supervisor_atual = $estagiario[0]['Estagiario']['supervisor_id'];
            $professor_atual = $estagiario[0]['Estagiario']['docente_id'];
            $aluno_nome = $estagiario[0]['Estudante']['nome'];
            // pr($nivel_ultimo);
            // echo "Período de estágio -> " . $periodo_ultimo . " Período atual -> " . $periodo . "<br />";
            // die('Período');
            // Se eh o periodo anterior adianta em uma unidade o nivel
            if ($nivel_ultimo < 4) {
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
            $this->loadModel('Estudante');
            $alunonovo = $this->Estudante->find('first', [
                'conditions' => ['Estudante.registro' => $id]
            ]);
            // die($alunonovo);
            // die("Alunonovo " . $alunonovo);
            // Aluno novo nao cadastrado: vai para cadastro e retorna
            if (!($alunonovo)) {
                $this->Session->setFlash(__("Estudante sem cadastro"));
                $this->Session->write('termo', $id);
                // die("Aluno novo nao cadastrado: " . $id);
                $this->redirect('/Estudantes/add/' . $id);
                die("Redireciona para cadastro de Estudante ");
            } else {
                $this->set('aluno', $alunonovo['Estudante']['nome']);
            }

            $this->set('instituicao_atual', 0);
            $this->set('supervisor_atual', 0);
            $this->set('professor_atual', 0);
        }

        // Pego as instituicoes
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', [
            'order' => 'Instituicao.instituicao',
            'fields' => ['Instituicao.id', 'Instituicao.instituicao']
                ]
        );
        // pr($instituicoes);
        // Pego os supervisores da instituicao atual
        // echo $instituicao_atual;
        // die('instituicao_atual');
        if (isset($instituicao_atual)) {
            $supervisores = $this->Instituicao->find('first', [
                'contain' => ['Supervisor'],
                'conditions' => ['Instituicao.id' => $instituicao_atual]
                    ]
            );
            // pr($supervisores);
            // die('supervisores');
            foreach ($supervisores['Supervisor'] as $c_supervisor) {
                $super_atuais[$c_supervisor['id']] = $c_supervisor['nome'];
                // pr($c_supervisor['nome']);
            }
            asort($super_atuais);
            // pr($super_atuais);
            // die('super_atuais');
        }

        // Envio os dados
        $this->set('id', $id);
        $this->set('periodo', $periodo);
        $this->set('nivel', $nivel_ultimo);
        $this->set('turno', $turno_ultimo);
        $this->set('instituicoes', $instituicoes);
        if (isset($super_atuais)) {
            $this->set('supervisores', $super_atuais);
        } else {
            $this->set('supervisores', null);
        }
    }

    /*
     * O id eh o numero de registro do aluno
     */

    public function termocadastra($id = NULL) {

        // echo $id;
        // Se ja esta como estagiario pego o id para atualizar
        $this->loadModel('Estagiario');
        $estagiario = $this->Estagiario->find('first', [
            'conditions' => ['Estagiario.registro' => $id]
        ]);
        // pr($estagiario);
        // die('estagiario');
        // Tem que ter o id da instituicao diferente de zero
        if (empty($this->request->data['Inscricao']['instituicao_id'])) {
            $this->Session->setFlash(__('Selecione uma instituição de estágio'));
            $this->redirect('/Inscricoes/termosolicita/');
            die('Faltou selecionar uma instituição');
        }

        if (empty($this->request->data['Inscricao']['supervisor_id'])) {
            $this->request->data['Inscricao']['supervisor_id'] = null;
        }

        /*
         *  Se é um estudante que já está em Estagio: inserir novo estagio.
         */
        if ($estagiario) {
            $estagiario_id = $estagiario['Estagiario']['id'];
            $aluno_id = $estagiario['Estagiario']['aluno_id'];

            // pr($aluno_id);
            // die('aluno_id');
            $dados = array("Estagiario" => array(
                    'aluno_id' => $aluno_id,
                    'registro' => $this->request->data['Inscricao']['aluno_id'],
                    'nivel' => $this->request->data['Inscricao']['nivel'],
                    'turno' => $this->request->data['Inscricao']['turno'],
                    'tc' => '1',
                    'tc_solicitacao' => date('Y-m-d'),
                    'periodo' => $this->request->data['Inscricao']['periodo'],
                    'instituicao_id' => $this->request->data['Inscricao']['instituicao_id'],
                    'supervisor_id' => $this->request->data['Inscricao']['supervisor_id']
            ));
            // pr($dados);
            // die('dados1');
            $this->loadModel('Estagiario');
            if ($this->Estagiario->save($dados)) {
                $this->Session->setFlash(__('Estagiário inseriddo'));
                $this->redirect('/Inscricoes/termoimprime/' . $this->Estagiario->id);
            }
        } else {
            // echo "Aluno não estagiario";
            $this->loadModel('Estudante');
            $alunonovo = $this->Estudante->find('first', array(
                'conditions' => array('Estudante.registro =' . $id)
            ));
            // pr($alunonovo);
            // die('alunonovo');

            /* Verifico se está cadastrdado como Aluno */
            $this->loadModel('Aluno');
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $id]
            ]);
            // pr($aluno);
            // die('aluno');
            if ($aluno) {
                echo "Cadastrado com Aluno." . "<br />";
                /*
                 * Inserir estagiario para este periodo
                 */
                $dados = array("Estagiario" => array(
                        'aluno_id' => $aluno['Aluno']['id'],
                        'registro' => $this->request->data['Inscricao']['aluno_id'],
                        'nivel' => $this->request->data['Inscricao']['nivel'],
                        'turno' => $this->request->data['Inscricao']['turno'],
                        'tc' => '1',
                        'tc_solicitacao' => date('Y-m-d'),
                        'periodo' => $this->request->data['Inscricao']['periodo'],
                        'instituicao_id' => $this->request->data['Inscricao']['instituicao_id'],
                        'supervisor_id' => $this->request->data['Inscricao']['supervisor_id']
                ));
                pr($dados);
                die('dados');
                $this->loadModel('Estagiario');
                if ($this->Estagiario->save($dados)) {
                    $this->Session->setFlash(__('Estagiario cadastrado'));
                    $this->redirect('/Inscricoes/termoimprime/' . $this->Estagiario->id);
                    // die('Sucesso Insert dados!');
                } else {
                    $this->Session->setFlash(__('Error: Estagiário não cadastrado. Tente mais uma vez.'));
                    // $log = $this->Estagiario->getDataSource()->getLog(false, false);
                    // debug($log);
                    // die('Error!');
                }
            } else {
                /*
                 * Aluno nao estagiário. Cadastrar
                 * Pode ser desnecessário se houver uma única tabela de estudantes
                 * Por precaução continuo com a tabela
                 */
                $cadastroaluno = ['Aluno' => [
                        'nome' => $alunonovo['Estudante']['nome'],
                        'registro' => $alunonovo['Estudante']['registro'],
                        'codigo_telefone' => $alunonovo['Estudante']['codigo_telefone'],
                        'telefone' => $alunonovo['Estudante']['telefone'],
                        'codigo_celular' => $alunonovo['Estudante']['codigo_celular'],
                        'celular' => $alunonovo['Estudante']['celular'],
                        'email' => $alunonovo['Estudante']['email'],
                        'cpf' => $alunonovo['Estudante']['cpf'],
                        'identidade' => $alunonovo['Estudante']['identidade'],
                        'orgao' => $alunonovo['Estudante']['orgao'],
                        'nascimento' => $alunonovo['Estudante']['nascimento'],
                        'endereco' => $alunonovo['Estudante']['endereco'],
                        'cep' => $alunonovo['Estudante']['cep'],
                        'municipio' => $alunonovo['Estudante']['municipio'],
                        'bairro' => $alunonovo['Estudante']['bairro'],
                        'observacoes' => $alunonovo['Estudante']['observacoes']
                ]];
                // pr($cadastroaluno);
                // die('cadastroaluno');
                $this->loadModel('Aluno');
                if ($this->Aluno->save($cadastroaluno)) {
                    $aluno_id = $this->Aluno->id;
                    $this->Session->setFlash(__('Aluno cadastrado'));

                    /*
                     * Inserir estagiario para este periodo
                     */
                    $dados = array("Estagiario" => array(
                            'aluno_id' => $aluno_id,
                            'registro' => $this->request->data['Inscricao']['aluno_id'],
                            'nivel' => $this->request->data['Inscricao']['nivel'],
                            'turno' => $this->request->data['Inscricao']['turno'],
                            'tc' => '1',
                            'tc_solicitacao' => date('Y-m-d'),
                            'periodo' => $this->request->data['Inscricao']['periodo'],
                            'instituicao_id' => $this->request->data['Inscricao']['instituicao_id'],
                            'supervisor_id' => $this->request->data['Inscricao']['supervisor_id']
                    ));
                    // pr($dados);
                    // die('dados');
                    $this->loadModel('Estagiario');
                    if ($this->Estagiario->save($dados)) {
                        $this->Session->setFlash(__('Estagiario cadastrado'));
                        $this->redirect('/Inscricoes/termoimprime/' . $this->Estagiario->id);
                        // die('Sucesso Insert dados!');
                    } else {
                        $this->Session->setFlash(__('Error: Estagiário não cadastrado. Tente mais uma vez.'));
                        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
                        // debug($log);
                        // die('Error!');
                    }
                }
            }
            // $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // die('Save aluno');
        }
    }

    /* id eh o numero de estagiario */

    public function termoimprime($id = NULL) {
        
        // echo $id;
        // die('id');
        $this->loadModel('Estagiario');
        $estagiario = $this->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id)
        ));
        // pr($estagiario);
        // die('estagiario');

        $instituicao_nome = $estagiario['Instituicao']['instituicao'];
        $supervisor_nome = $estagiario['Supervisor']['nome'];
        if (empty($supervisor_nome)) {
            $supervisor_nome = NULL;
        }
        $aluno_nome = $estagiario['Estudante']['nome'];
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
        // die('set');
        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

}

?>
