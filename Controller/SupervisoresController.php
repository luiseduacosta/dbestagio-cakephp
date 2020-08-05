<?php

class SupervisoresController extends AppController {

    public $name = 'Supervisores';
    public $components = array('Auth');
    public $paginate = [
        'contain' => [
            'Estagiario' => ['fields' => ['Estagiario.registro', 'Estagiario.periodo']],
            'Instituicao' => ['fields' => ['Instituicao.instituicao']],
        ],
        'limit' => 25,
        'fields' => ['Supervisor.id', 'Supervisor.cress', 'Supervisor.nome'],
        'order' => ['Supervisor.nome' => 'asc']
    ];

    public function beforeFilter() {
        // pr($this->Session->read('id_categoria'));
        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash(__("Administrador"), "flash_notification");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'busca');
            // $this->Session->setFlash(__("Estudante"), "flash_notification");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add', 'edit', 'addinstituicao', 'deleteassociacao', 'index', 'view', 'busca');
            // $this->Session->setFlash(__("Professor"), "flash_notification");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('add', 'edit', 'addinstituicao', 'deleteassociacao', 'index', 'view', 'busca');
            // $this->Session->setFlash(__("Supervisor"), "flash_notification");
        } else {
            $this->Session->setFlash(__("Não autorizado"), "flash_notification");
            $this->redirect('/Userestagios/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    /*
      Mostra a totalidade dos supervisores por periodo e quantidade de estagiarios
     */

    public function index() {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : NULL;
        // pr($periodo);
        if (!isset($ordem) or empty($ordem)) {
            $ordem = 'nome';
        }

        /* Para caixa de seleção dos períodos */
        $this->loadModel('Estagiario');
        $todosPeriodos = $this->Estagiario->find('list', [
            'fields' => ['Estagiario.periodo', 'Estagiario.periodo'],
            'group' => ['Estagiario.periodo'],
            'order' => ['Estagiario.periodo']
        ]);

        $supervisores = $this->Supervisor->find('all', [
            'contain' => [
                'Estagiario' => ['fields' => ['Estagiario.registro', 'Estagiario.periodo']],
                'Instituicao' => ['fields' => ['Instituicao.instituicao']]
            ],
            'order' => ['Supervisor.nome' => 'asc']
        ]);

        // pr($supervisores);
        // die('supervisores');
        $i = 0;
        foreach ($supervisores as $c_supervisor) {
            // pr($c_supervisor['Estagiario']);
            $supervisor[$i]['id'] = $c_supervisor['Supervisor']['id'];
            $supervisor[$i]['cress'] = $c_supervisor['Supervisor']['cress'];
            $supervisor[$i]['nome'] = $c_supervisor['Supervisor']['nome'];
            $supervisor[$i]['q_estagiarios'] = count($c_supervisor['Estagiario']);
            if (count($c_supervisor['Estagiario']) > 1) {
                $supervisor[$i]['periodo'] = $c_supervisor['Estagiario'][count($c_supervisor['Estagiario']) - 1]['periodo'];
            } elseif (count($c_supervisor['Estagiario']) === 1) {
                $supervisor[$i]['periodo'] = $c_supervisor['Estagiario'][0]['periodo'];
            } else {
                $supervisor[$i]['periodo'] = null;
            }

            /*
             * Conta a quantidade de períodos e de estudantes por cada supervisor
             */
            $e = 0;
            $estagiariosporsupervisorperiodo = null;
            $estagiariosporsupervisorregistro = null;
            foreach ($c_supervisor['Estagiario'] as $c_estagiario) {
                // pr($c_estagiario);
                $estagiariosporsupervisorperiodo[$e] = $c_estagiario['periodo'];
                $estagiariosporsupervisorregistro[$e] = $c_estagiario['registro'];
                $e++;
                // die();
            }

            if (!empty($estagiariosporsupervisorperiodo)) {
                $contaperiodos = count(array_count_values($estagiariosporsupervisorperiodo));
                // pr($contaperiodos);
            } else {
                $contaperiodos = 0;
            }
            // echo 'Períodos =' . $contaperiodos . '<br />';
            $supervisor[$i]['q_periodos'] = $contaperiodos;

            if (!empty($estagiariosporsupervisorregistro)) {
                $contaregistros = count(array_count_values($estagiariosporsupervisorregistro));
            } else {
                $contaregistros = 0;
            }
            // echo 'Registros =' . $contaregistros . '<br />';
            $supervisor[$i]['q_estudantes'] = $contaregistros;
            // die('c_estagiario');
            $i++;

            // die('supervisor');
        }

        $coluna = array_column($supervisor, $ordem);
        array_multisort($coluna, $supervisor);
        // pr($supervisor);
        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        // $this->set('supervisores', $this->Paginator->paginate('Supervisor'));
        $this->set('supervisores', $supervisor);
    }

    /*
      Mostra os supervisores por periodo e quantidde de estudantes no período
     */

    public function index1() {
        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : NULL;
        // pr($periodo);
        if (!isset($ordem) or empty($ordem)) {
            $ordem = 'nome';
        }

        if (!isset($periodo) or empty($periodo)) {
            $this->redirect('/Supervisores/index');
        }

        /* Para caixa de seleção dos períodos */
        $this->loadModel('Estagiario');
        $todosPeriodos = $this->Estagiario->find('list', [
            'fields' => ['Estagiario.periodo', 'Estagiario.periodo'],
            'group' => ['Estagiario.periodo'],
            'order' => ['Estagiario.periodo']
        ]);

        if ($periodo) {
            $supervisores = $this->Supervisor->Estagiario->find('all', [
                'fields' => ['Supervisor.id', 'Supervisor.nome', 'Supervisor.cress', 'Estagiario.id', 'Estagiario.registro', 'Estagiario.periodo', 'Instituicao.id', 'Instituicao.instituicao'],
                'conditions' => ['Estagiario.periodo' => $periodo],
                'order' => ['Supervisor.nome']
            ]);
        }
        // pr($supervisores);
        // die('supervisores');

        $i = 0;
        $estagiarios = null;
        $supervisor = null;
        $repetido = null;
        foreach ($supervisores as $c_supervisor) {
            // pr($c_supervisor['Estagiario']);
            // pr($supervisor);

            /*
             * Carrego a lista dos registros repetidos para serem excluídos
             */
            if (!empty($supervisor)) {
                foreach ($supervisor as $value):
                    if ($value['cress'] === $c_supervisor['Supervisor']['cress']):
                        $repetido[] = $i;
                    // echo "Repetido: " . $i . "<br />";
                    endif;
                endforeach;
            };

            $supervisor[$i]['id'] = $c_supervisor['Supervisor']['id'];
            $supervisor[$i]['cress'] = $c_supervisor['Supervisor']['cress'];
            $supervisor[$i]['nome'] = $c_supervisor['Supervisor']['nome'];
            if ($c_supervisor['Supervisor']['id']) {
                /* Estagiarios do período do supervisor */
                $estagiarios = $this->Supervisor->Estagiario->find('all', [
                    'conditions' => ['Supervisor.id' => $c_supervisor['Supervisor']['id'], 'Estagiario.periodo' => $periodo],
                    'fields' => ['count("Estagiario.id") AS q_estagiarios']
                ]);
                // pr($estagiarios);
                // die('estagiarios');
                /* Todos os estagiarios do supervisor */
                $estagiariostotaldosupervisor = $this->Supervisor->Estagiario->find('all', [
                    'conditions' => ['Supervisor.id' => $c_supervisor['Supervisor']['id']],
                    'fields' => ['count("Estagiario.id") AS q_estagiarios']
                ]);
                // pr($estagiariostotaldosupervisor);
                // die('estagiariostotaldosupervisor');

                /* Todos os periodos de estágio do supervisor */
                $periodostotaldosupervisor = $this->Supervisor->Estagiario->find('all', [
                    'conditions' => ['Supervisor.id' => $c_supervisor['Supervisor']['id']],
                    'fields' => ['Estagiario.periodo']
                ]);
                // pr($periodostotaldosupervisor);
                // die('periodostotaldosupervisor');
                $periodosdeestagio = null;
                foreach ($periodostotaldosupervisor as $c_periodo) {
                    $periodosdeestagio[] = $c_periodo['Estagiario']['periodo'];
                }
                // die('periodostotaldosupervisor');
            }
            /* Quantidade de períodos do supervisor */
            if (isset($periodosdeestagio) && $periodosdeestagio) {
                $periodosunicos = array_unique($periodosdeestagio);
                $supervisor[$i]['q_periodos'] = count($periodosunicos);
            } else {
                $supervisor[$i]['q_periodos'] = null;
            }
            $q_estagiarios = isset($estagiarios[0][0]['q_estagiarios']) ? $estagiarios[0][0]['q_estagiarios'] : null;
            $supervisor[$i]['q_estagiarios'] = $q_estagiarios;

            $estagiariostotal = isset($estagiariostotaldosupervisor[0][0]['q_estagiarios']) ? $estagiariostotaldosupervisor[0][0]['q_estagiarios'] : null;
            $supervisor[$i]['q_totaldeestagiarios'] = $estagiariostotal;

            $supervisor[$i]['instituicao_id'] = $c_supervisor['Instituicao']['id'];
            $supervisor[$i]['instituicao'] = $c_supervisor['Instituicao']['instituicao'];
            $i++;
        }
        // die();
        // pr($supervisor);
        /*
         * Para excluir os supervisores repetidos
         */
        $repetidounicakey = array_unique($repetido);
        foreach ($repetidounicakey as $key):
            // pr($key);
            unset($supervisor[$key]);
        endforeach;
        // pr($supervisor);

        /*
         * Ordeno o array por uma coluna
         */
        $coluna = array_column($supervisor, $ordem);
        array_multisort($coluna, $supervisor);
        // pr($supervisor);
        // die('supervisor');

        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        $this->set('supervisores', $supervisor);
    }

    public function view($id = NULL) {

        if ($this->Session->read('numero')) {
            $supervisor = $this->Supervisor->find('first', [
                'conditions' => ['Supervisor.cress' => $this->Session->read('numero')]
            ]);
            if (!$superivosr) {
                $this->Session->setFlash(__("Acesso não autorizado"), "flash_notification");
                $this->redirect("/Supervisores/index");
                die("Não autorizado");
            }
        }
        $parametros = $this->params['named'];
        $cress = isset($parametros['cress']) ? $parametros['cress'] : null;
        // pr($cress);
        // pr('id: ' . $id);
        // die('parametros');
        if ($id) {
            $supervisor = $this->Supervisor->find('all', [
                'conditions' => ['Supervisor.id' => $id]
            ]);
        } else {
            $supervisor = $this->Supervisor->find('all', [
                'conditions' => ['Supervisor.cress' => $cress]
            ]);
        }
        // pr($supervisor);
        // die('supervisor');
        // echo sizeof($supervisor[0]['Estagiario']);
        if ($supervisor) {
            $this->loadModel('Estudante');
            foreach ($supervisor as $c_supervisor) {
                // pr($c_supervisor['Estagiario']);
                $j = 0;
                foreach ($c_supervisor['Estagiario'] as $c_estagiario) {
                    // pr($c_estagiario);
                    $estagiarios = $this->Estudante->find('first', [
                        'conditions' => ['Estudante.registro' => $c_estagiario['registro']],
                        'order' => 'Estudante.nome'
                    ]);
                    // pr($estagiarios);
                    // die();
                    $estudante_estagiario[$j]['nome'] = $estagiarios['Estudante']['nome'];
                    $estudante_estagiario[$j]['registro'] = $estagiarios['Estudante']['registro'];
                    $estudante_estagiario[$j]['id'] = $estagiarios['Estudante']['id'];
                    $estudante_estagiario[$j]['periodo'] = $c_estagiario['periodo'];
                    $estudante_estagiario[$j]['nivel'] = $c_estagiario['nivel'];
                    $j++;
                }
            }
            // pr($estudante_estagiario);
            // die('estudante_estagiario');
            array_multisort(array_column($estudante_estagiario, 'nome'), $estudante_estagiario);
            $this->set('estagiarios', $estudante_estagiario);
        }

        /* Para o select de inserir uma nova instituicao */
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', ['order' => 'Instituicao.instituicao']);
        $this->set('instituicoes', $instituicoes);
        // pr(count($supervisor));
        // die();
        $this->set('supervisor', $supervisor);
    }

    public function add() {

        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', ['order' => 'Instituicao.instituicao']);
        $instituicoes[0] = '- Seleciona -';
        asort($instituicoes);
        $this->set('instituicoes', $instituicoes);

        /* Meses em português */
        $this->set('meses', $this->meses());

        if ($this->request->data) {
            /*
             * Verifica que não esteja repetido o Cress
             */
            $verifica = $this->Supervisor->find('first', [
                'conditions' => ['Supervisor.cress' => $this->request->data['Supervisor']['cress']]
            ]);
            if ($verifica) {
                $this->Session->setFlash(__('Supervisor já cadastrado'), "flash_notification");
                $this->redirect('/Supervisores/view/' . $verifica['Supervisor']['id']);
            } else {
                // pr($this->data);
                // die();
                if ($this->Supervisor->save($this->data)) {
                    $this->Session->setFlash(__('Dados inseridos'), "flash_notification");
                    $this->redirect('/Supervisores/view/' . $this->Supervisor->id);
                }
            }
        }
    }

    public function busca($id = NULL) {

        if (isset($id))
            $this->request->data['Supervisor']['nome'] = $id;

        // $id = isset($this->request->data['Supervisor']['nome']) ? $this->request->data['Supervisor']['nome'] : null;
        // pr($id);
        if (!empty($this->request->data['Supervisor']['nome'])) {
            $condicao = ['Supervisor.nome like' => '%' . $this->request->data['Supervisor']['nome'] . '%'];
            $supervisores = $this->Supervisor->find('all', [
                'recursive' => -1, // Para excluir as associações
                'conditions' => $condicao,
                'order' => 'Supervisor.nome']);

            // pr($supervisores);
            // die('supervisores');

            /* Nenhum resultado */
            if (empty($supervisores)) {
                $this->Session->setFlash(__("Não foram encontrados registros"), "flash_notification");
            } else {
                // pr($supervisores);
                // die('supervisores');
                $this->Paginator->settings = ['Supervisor' => [
                        'conditions' => ['Supervisor.nome like' => '%' . $this->request->data['Supervisor']['nome'] . '%'],
                        'order' => 'Supervisor.nome'
                    ]
                ];
                $this->set('supervisores', $this->Paginator->paginate('Supervisor'));
                $this->set('busca', $this->request->data['Supervisor']['nome']);
            }
        }
    }

    public function edit($id = NULL) {

        $this->Supervisor->id = $id;

        /* Meses em português */
        $this->set('meses', $this->meses());

        if (empty($this->data)) {
            $this->data = $this->Supervisor->read();
        } else {
            if ($this->Supervisor->save($this->data)) {
                // print($id);
                // die();
                // print_r($this->data);
                $this->Session->setFlash(__("Atualizado"), "flash_notification");
                $this->redirect('/Supervisores/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {
        $supervisores = $this->Supervisor->find('first', array(
            'conditions' => array('Supervisor.id' => $id)
        ));
        // pr($supervisores);
        // die();
        if ($supervisores['Estagiario']) {
            $this->Session->setFlash(__('Há estagiários vinculados a este supervisor'), "flash_notification");
            $this->redirect('/Supervisores/view/' . $id);
            exit;
        } elseif ($supervisores['Instituicao']) {
            $this->Session->setFlash(__('Há instituições vinculadas a este supervisor'), "flash_notification");
            $this->redirect('/Supervisores/view/' . $id);
            exit;
        } else {
            $this->Supervisor->delete($id);
            $this->Session->setFlash(__("Supervisor excluido"), "flash_notification");
            $this->redirect('/Supervisores/index/');
        }
    }

    public function addinstituicao() {
        if ($this->request->data) {
            // pr($this->data);
            // die();
            if ($this->Supervisor->InstituicaoSupervisor->save($this->request->data)) {
                $this->Session->setFlash(__('Dados inseridos'), "flash_notification");
                $this->redirect('/Supervisores/view/' . $this->request->data['InstituicaoSupervisor']['supervisor_id']);
            }
        }
    }

    public function deleteassociacao($id = NULL) {
        $id_superinstituicao = $this->Supervisor->InstituicaoSupervisor->find('first', array('conditions' => 'InstituicaoSupervisor.id= ' . $id));
        // pr($id_superinstituicao);
        // die();
        $this->Supervisor->InstituicaoSupervisor->delete($id);
        $this->Session->setFlash(__("Instituição excluída do supervisor"), "flash_notification");
        $this->redirect('/Supervisores/view/' . $id_superinstituicao['InstituicaoSupervisor']['supervisor_id']);
    }

    public function repetidos() {
        $supervisores = $this->Supervisor->find('all', [
            'recursive' => -1, // não trazer as tabelas associadas
            'fields' => ['Supervisor.cress', 'count("cress") as q_cress'],
            'group' => ['Supervisor.cress']
        ]);

        // pr($supervisores);

        $i = 0;
        $semcress = null;
        foreach ($supervisores as $c_supervisor) {
            // pr($c_supervisor);
            if ($c_supervisor[0]['q_cress'] > 1) {
                // echo $c_supervisor[0]['q_cress'];
                // pr($c_supervisor['Supervisor']);
                if ($c_supervisor['Supervisor']['cress'] == 0 || empty($c_supervisor['Supervisor']['cress'])) {
                    // $semcress[$i]['nome'] = null;
                    $semcress = $semcress + $c_supervisor[0]['q_cress'];
                } else {
                    $supervisornome = $this->Supervisor->find('first', [
                        'recursive' => -1,
                        'conditions' => ['Supervisor.cress' => $c_supervisor['Supervisor']['cress']]
                    ]);
                    // pr($supervisornome);
                    $repetidos[$i]['id'] = $supervisornome['Supervisor']['id'];
                    $repetidos[$i]['nome'] = $supervisornome['Supervisor']['nome'];
                    $repetidos[$i]['cress'] = $c_supervisor['Supervisor']['cress'];
                    $repetidos[$i]['q_cress'] = $c_supervisor[0]['q_cress'];
                }
            }
            $i++;
        }
        // die('supervisornome');
        // pr($semcress);
        array_multisort(array_column($repetidos, 'nome'), $repetidos);
        // pr($repetidos);
        // die('repetidos');
        $this->set('semcress', $semcress);
        $this->set('repetidos', $repetidos);
    }

    public function semalunos() {

        $this->Supervisor->recursive = 1;
        $semalunos = $this->Supervisor->find('all');

        $i = 0;
        foreach ($semalunos as $estagiarios) {
            // pr($estagiarios);
            if (count($estagiarios['Estagiario']) > 0) {
                // echo "Estagiarios" . "<br />";
            } else {
                // echo 'Sem estagiarios' . "<br />";
                $semestudantes[] = $estagiarios['Supervisor'];
            }
        }
        array_multisort(array_column($semestudantes, 'nome'), $semestudantes);
        // pr($semestudantes);
        // die('semalunos');
        $this->set('semalunos', $semestudantes);
    }

    public function seminstituicao($id = null) {

        $this->Supervisor->recursive = 1;
        $supervisores = $this->Supervisor->find('all');
        $i = 0;
        foreach ($supervisores as $instituicao) {
            if (count($instituicao['Instituicao']) > 0) {
                // pr($instituicao['Instituicao'][array_key_last($instituicao['Instituicao'])]['instituicao']);
            } else {
                // echo "Sem instituição";
                $seminstituicao[$id]['supervisor_id'] = $instituicao['Supervisor']['id'];
                $seminstituicao[$id]['nome'] = $instituicao['Supervisor']['nome'];
                $seminstituicao[$id]['cress'] = $instituicao['Supervisor']['cress'];
                $seminstituicao[$id]['q_estagiarios'] = count($instituicao['Estagiario']);
                $id++;
            }
        }
        array_multisort(array_column($seminstituicao, 'nome'), $seminstituicao);
        // die('supervisores');
        $this->set('seminstituicao', $seminstituicao);
    }

}

?>
