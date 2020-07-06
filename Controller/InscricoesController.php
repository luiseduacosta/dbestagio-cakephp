<?php

class InscricoesController extends AppController {

    public $name = "Inscricoes";
    public $components = array('Email', 'Auth');
    public $paginate = [
        'limit' => 25,
        'order' => ['Inscricao.estudante_id']
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
            $inscritos = $this->Inscricao->Muralestagio->find('first', [
                'conditions' => ['Muralestagio.id' => $id]
            ]);
            // pr($inscritos);
            // die('id inscritos');
            if ($inscritos) {
                $vagas = $inscritos['Muralestagio']['vagas'];
                $instituicao_id = $inscritos['Muralestagio']['estagio_id'];
                $mural_estagio_id = $inscritos['Muralestagio']['id'];
                $instituicao = $inscritos['Muralestagio']['instituicao'];
                // die();
            }
            // die('id');
        } else {
            $inscritos = $this->Inscricao->find('all', [
                'conditions' => ['Inscricao.periodo' => $periodo]
            ]);
        }
        // pr($inscritos);
        // die();
        // Somente se há inscritos e a consulta tem origem numa instituição
        if ($inscritos) {
            // pr($inscritos);
            // die('inscritos');
            // Junto todo num array para ordernar alfabeticamente
            $i = 0;
            $alunos_estagiarios = 0;
            $alunos_novos = 0;
            $inscritos_ordem = null;
            foreach ($inscritos as $c_inscritos) {
                // pr($c_inscritos);
                // die('c_inscritos');
                $estudante = $this->Inscricao->Estudante->find('first', [
                    'conditions' => ['Estudante.id' => $c_inscritos['Inscricao']['estudante_id']]
                ]);
                // pr($estudante);
                // die();
                /* Capturo os estudantes que estão repetidos */
                if (isset($inscritos_ordem)):
                    if ($inscritos_ordem[array_key_last($inscritos_ordem)]['estudante_id'] == $c_inscritos['Estudante']['id']):
                        $repetidos[$i] = $i;
                    endif;
                endif;
                $inscritos_ordem[$i]['nome'] = $estudante['Estudante']['nome'];
                $inscritos_ordem[$i]['estudante_id'] = $estudante['Estudante']['id'];
                /*  Conta a quantidade de inscrições por estudante no período */
                $inscricoesporestudante = $this->Inscricao->find('all', [
                    'fields' => ['count(Inscricao.registro) as q_inscricaoporestudante'],
                    'conditions' => ['Inscricao.estudante_id' => $c_inscritos['Estudante']['id'],
                        ['Inscricao.periodo' => $periodo]]
                ]);
                // pr($inscricoesporestudante);
                // die('inscricoesporestudante');
                $inscritos_ordem[$i]['q_inscricoes'] = $inscricoesporestudante[0][0]['q_inscricaoporestudante'];
                $inscritos_ordem[$i]['inscricao_id'] = $c_inscritos['Inscricao']['id'];
                $inscritos_ordem[$i]['registro'] = $c_inscritos['Inscricao']['registro'];
                $inscritos_ordem[$i]['estudante_id'] = $c_inscritos['Inscricao']['estudante_id'];
                $inscritos_ordem[$i]['periodo'] = $c_inscritos['Inscricao']['periodo'];

                if (!is_null($estudante['Estudante']['nascimento'])) {
                    $inscritos_ordem[$i]['nascimento'] = $estudante['Estudante']['nascimento'];
                } else {
                    $inscritos_ordem[$i]['nascimento'] = 's/d';
                }

                $inscritos_ordem[$i]['telefone'] = $estudante['Estudante']['telefone'];
                $inscritos_ordem[$i]['celular'] = $estudante['Estudante']['celular'];
                $inscritos_ordem[$i]['email'] = $estudante['Estudante']['email'];

                /* Capturo se é estagiário ou não */
                $this->loadModel('Estagiario');
                $estagiario = $this->Estagiario->find('first', [
                    'conditions' => ['Estagiario.estudante_id' => $c_inscritos['Estudante']['id']]
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
            // pr($repetidos);
            // die('repetidos');
            if (isset($repetidos) and (!empty($repetidos))):
                $inscritos_ordem_unicos = array_diff_key($inscritos_ordem, $repetidos);
            else:
                $inscritos_ordem_unicos = $inscritos_ordem;
            endif;
            // pr($inscritos_ordem_unicos);
            // die('inscritos_ordem_unicos');
            array_multisort(array_column($inscritos_ordem_unicos, $ordem), SORT_ASC, $inscritos_ordem_unicos);
        }
        // pr($inscritos_ordem_unicos);
        // die('inscricao_ordem_unicos');
        /* Descrimino pela variavel Tipo os estagiários: 0 => Sem estágio, 1 => Com estágio */

        $estudantetipos = array_count_values(array_column($inscritos_ordem_unicos, 'tipo'));
        // echo $estudantestipos[0] . " " . $estudantestipos[1] . "<br />";
        $estudanteregistros = array_count_values(array_column($inscritos_ordem_unicos, 'registro'));
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
        $this->set('inscritos', $inscritos_ordem_unicos);
    }

    public function orfao() {

        $this->loadModel('Estudante');
        $orfaos = $this->Estudante->alunonovorfao();
        // $log = $this->Inscricao->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($orfaos);
        // die();
        $this->set('orfaos', $orfaos);
    }

    public function add($id = NULL) {

        $parametros = $this->params['named'];
        $registro = isset($parametros['registro']) ? $parametros['registro'] : null;
        $mural_estagio_id = isset($parametros['mural_estagio_id']) ? $parametros['mural_estagio_id'] : null;

        $this->set('mural_estagio_id', $mural_estagio_id);

        /* 1 - Verifico se foi preenchido o numero de registro */
        if (isset($registro)) {
            // pr($this->request->data);
            // die();
            /* Verificacoes */
            if (strlen($registro) < 9) {
                $this->Session->setFlash(__("Falta o número de registro ou número de registro incorreto."));
                if ($this->Session->read('id_categoria') == 2):
                    $this->redirect('/Estudantes/view/' . $this->Session->read('numero'));
                else:
                    $this->redirect('/Muralestagios/index/');
                endif;
                die("Registro incorreto");
                exit;
            }
        } else {
            $this->Session->setFlash(__("Sem número de registro de estudante"));
            $this->redirect('/Muralestagios/index/');
        }
    }

    /*
     * Inscreve o aluno para seleção de estágio
     * Esta função é chamada desde a função add() e traz como parámetro o registro
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

        // pr($this->request->data);
        // die();
        /*
         * Verifica se já fez inscrição para esta seleção de estágio
         */
        $selecaoestagio = $this->Inscricao->find('first', [
            'conditions' => ['Inscricao.registro' => $this->request->data['Inscricao']['registro'],
                'Inscricao.mural_estagio_id' => $this->request->data['Inscricao']['mural_estagio_id']]
        ]);
        // pr($selecaoestagio);
        // die();
        /*
         * Se já fez mostra a Inscricao/view
         */
        if ($selecaoestagio) {
            $this->Session->setFlash(__('Inscrição para seleção de estágio já realizada'));
            $this->redirect('/Inscricoes/view/' . $selecaoestagio['Inscricao']['id']);
            /*
             * Se não fez vai para Estudante/view para atualizar seus dados
             */
        } else {

            /* Capturo o periodo para o registro de inscricao */
            $periodo_mural_estagio = $this->Inscricao->Muralestagio->find('first', [
                'conditions' => ['Muralestagio.id' => $mural_estagio_id],
                'fields' => ['Muralestagio.periodo']]);

            // pr($periodo_mural_estagio);
            // die();
            $periodo = $periodo_mural_estagio['Muralestagio']['periodo'];
            // echo "Período: " . $periodo;
            // die('periodo');

            /* Capturo o estudante_id para o registro da inscricao */
            $estudante_mural_estagio = $this->Inscricao->Estudante->find('first', [
                'conditions' => ['Estudante.registro' => $registro],
                'fields' => ['Estudante.id', 'Estudante.nome']]);
            // pr($estudante_mural_estagio);
            // die('estudante_mural_estagio');

            /* Carrego o array de inscrição com os valores */
            $this->request->data['Inscricao']['estudante_id'] = $estudante_mural_estagio['Estudante']['id'];
            $this->request->data['Inscricao']['periodo'] = $periodo;
            $this->request->data['Inscricao']['mural_estagio_id'] = $mural_estagio_id;
            $this->request->data['Inscricao']['data'] = date('Y-m-d');
            $this->request->data['Inscricao']['registro'] = $registro;

            // debug($this->data);
            // pr($this->data);
            // die();

            if ($this->Inscricao->save($this->request->data)) {
                $this->Session->setFlash(__("Inscrição realizada"));
                $this->redirect('/Inscricoes/view/' . $this->Inscricao->id);
            }
        }
    }

    public function view($id = NULL) {

        $inscricao = $this->Inscricao->find('first', [
            'conditions' => ['Inscricao.id' => $id]
        ]);
        // pr($inscricao);
        // die();
        $this->set('inscricao', $inscricao);
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
                'fields' => array('Inscricao.id', 'Inscricao.registro', 'Estudante.nome', 'Estudante.celular', 'Estudante.telefone', 'Estudante.email', 'Muralestagio.id', 'Muralestagio.instituicao', 'Muralestagio.email', 'Inscricao.instituicao_id'),
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
            $registro = $this->request->data['Inscricao']['registro'];
            // pr($registro);
            // die("termosoliciata");
            $this->redirect('/Inscricoes/termocompromisso/registro:' . $registro);
        }
    }

    // Com o numero de registro busco as informacoes em estagiario ou estudante
    // Se nao esta cadastrado em estudante faço o cadastramento
    // Se nao eh estagiario eh um estudante entao faço cadastramento
    public function termocompromisso($id = NULL) {

        $parametros = $this->params['named'];
        $registro = isset($parametros['registro']) ? $parametros['registro'] : NULL;

        // Captura o periodo de estagio para o termo de compromisso
        // pr($id);
        // die("termocompromisso ");
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];
        // die("configuração");

        $estagiario = $this->Inscricao->Estudante->find('first', [
            'contain' => ['Estagiario'],
            'conditions' => ['Estudante.registro' => $registro]
        ]);
        // pr($estagiario);
        // die('estagiario');
        /*
         *  Se retorna um valor maior que 0 quer dizer que eh estagiario
         */
        if (sizeof($estagiario['Estagiario']) > 0) {
            // echo "Estudante estagiario" . "<br />";
            // pr($estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]);
            // die();
            $periodo_ultimo = $estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]['periodo'];
            $nivel_ultimo = $estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]['nivel'];
            $ajustecurricular2020 = $estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]['ajustecurricular2020'];
            $turno_ultimo = $estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]['turno'];
            $instituicao_atual = $estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]['instituicao_id'];
            $supervisor_atual = $estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]['supervisor_id'];
            $professor_atual = $estagiario['Estagiario'][array_key_last($estagiario['Estagiario'])]['docente_id'];
            $aluno_nome = $estagiario['Estudante']['nome'];
            // pr($nivel_ultimo);
            // echo "Período de estágio -> " . $periodo_ultimo . " Período atual -> " . $periodo . "<br />";
            // die('Período');
            // Se eh o periodo anterior adianta em uma unidade o nivel
            if ($periodo_ultimo == $periodo) {
                $nivel_ultimo = $nivel_ultimo;
            } else {
                if ($ajustecurricular2020 === '0') {
                    $ultimoestagio = 4;
                } elseif ($ajustecurricular2020 === '1') {
                    $ultimoestagio = 3;
                } else {
                    $ultimoestagio = 4;
                }
                if ($nivel_ultimo < $ultimoestagio) {
                    $nivel_ultimo++;
                } else {
                    $nivel_ultimo = 9; // Estágio não obrigatorio
                }
            }
        } else {
            // Aluno nao estagiario ingressante
            // Turno incompleto (ou ignorado)
            $turno_ultimo = 'I';

            // Nivel eh I
            $nivel_ultimo = 1;

            $this->set('aluno', $estagiario['Estudante']['nome']);
            $this->set('instituicao_atual', 0);
            $this->set('supervisor_atual', 0);
            $this->set('professor_atual', 0);
        }
        
        $this->set('aluno', $aluno_nome);
        $this->set('instituicao_atual', $instituicao_atual);
        $this->set('supervisor_atual', $supervisor_atual);
        $this->set('professor_atual', $professor_atual);


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
        $this->set('registro', $registro);
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

        $parametros = $this->params['named'];
        $registro = isset($parametros['registro']) ? $parametros['registro'] : NULL;

        // echo $registro . '<br>';
        // die('registro');
        // pr($this->request->data);
        // die('this->request-data');
        // Tem que ter o id da instituicao diferente de zero
        if (empty($this->request->data['Inscricao']['instituicao_id'])) {
            $this->Session->setFlash(__('Selecione uma instituição de estágio'));
            $this->redirect('/Inscricoes/termosolicita/');
            die('Faltou selecionar uma instituição');
        }

        if (empty($this->request->data['Inscricao']['supervisor_id'])) {
            $this->request->data['Inscricao']['supervisor_id'] = null;
        }

        /* 1o. inserir dados na tabela Aluno. É uma tabela antiga que vai ser eliminada */
        $this->loadModel('Estudante');
        $alunonovo = $this->Estudante->find('first', [
            'conditions' => ['Estudante.registro' => $registro]
        ]);
        // pr($alunonovo);
        // die('alunonovo');
        if (empty($alunonovo)) {
            $this->Session->setFlash(__('Estudante não cadastrado'));
            $this->redirect('/Estudantes/add/registro:' . $registro);
            die('alunonovo');
        }
        /* Verificar antes por se já está na tabela Aluno */
        $this->loadModel('Aluno');
        $verifica = $this->Aluno->find('first', [
            'conditions' => ['Aluno.registro' => $registro]
        ]);
        /* Carrego aqui a varíavel $aluno_id. Se um aluno foi inserido a varíavel vai ter outro valor */
        // pr(!empty($verifica));
        $aluno_id = !empty($verifica) ? $verifica['Aluno']['id'] : null;
        // pr($verifica);
        // die('verifica');
        if (empty($verifica)) {
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
            if ($this->Aluno->save($cadastroaluno)) {
                $aluno_id = $this->Aluno->id;
                // $this->Session->setFlash(__('Aluno cadastrado'));
            }
        }
        /* 2o. inserir dados na tabela Estagiario. */
        $dados = array("Estagiario" => array(
                'aluno_id' => $aluno_id,
                'estudante_id' => $alunonovo['Estudante']['id'],
                'registro' => $alunonovo['Estudante']['registro'],
                'turno' => $this->request->data['Inscricao']['turno'],
                'nivel' => $this->request->data['Inscricao']['nivel'],
                'tc' => '1',
                'tc_solicitacao' => date('Y-m-d'),
                'instituicao_id' => $this->request->data['Inscricao']['instituicao_id'],
                'supervisor_id' => $this->request->data['Inscricao']['supervisor_id'],
                'docente_id' => null,
                'periodo' => $this->request->data['Inscricao']['periodo'],
                'areaestagio_id' => null
        ));
        // pr($dados);
        // die('dados');
        $this->loadModel('Estagiario');
        if ($this->Estagiario->save($dados)) {
            // $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // die('Save aluno');
            $this->Session->setFlash(__('Estagiario cadastrado'));
            $this->redirect('/Inscricoes/termoimprime/' . $this->Estagiario->id);
            // die('Sucesso Insert dados!');
        }
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        die('Save aluno2');
    }

    /* id eh o numero de estagiario */

    public function termoimprime($id = NULL) {

        $this->loadModel('Estagiario');
        $estagiario = $this->Estagiario->find('first', [
            'conditions' => ['Estagiario.id' => $id]
        ]);
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

    public function estudantes() {

        $inscricoes = $this->Inscricao->find('all', [
            'fields' => 'Inscricao.registro'
        ]);
        // pr($inscricoes);
        $this->loadModel('Estudante');
        foreach ($inscricoes as $c_inscricao) {
            // pr($c_inscricao);
            // die('c_inscricao');
            $estudante = $this->Estudante->find('first', [
                'conditions' => ['Estudante.registro' => $c_inscricao['Inscricao']['registro']]
            ]);
            // pr($estudante['Estudante']);
            if ($estudante) {
                $query = "UPDATE muralinscricoes as Inscricao "
                        . "SET Inscricao.estudante_id = " . $estudante['Estudante']['id']
                        . " WHERE Inscricao.registro = " . $estudante['Estudante']['registro'];
                pr($query);

                $this->Inscricao->query($query);
            } else {
                echo ' Estudante sem inscricão ' . "<br>";
            }

            // die();
        }
        die();
    }

}

?>
