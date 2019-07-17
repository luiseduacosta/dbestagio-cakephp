<?php

class EstagiariosController extends AppController {

    public $name = 'Estagiarios';
    public $components = array('Auth');
    // var $scaffold;
    // var $helpers = array('Javascript');
    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Aluno.nome' => 'asc')
    );

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash("Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/users/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $id_area = isset($parametros['id_area']) ? $parametros['id_area'] : NULL;
        $id_aluno = isset($parametros['id_aluno']) ? $parametros['id_aluno'] : NULL;
        $id_professor = isset($parametros['id_professor']) ? $parametros['id_professor'] : NULL;
        $id_instituicao = isset($parametros['id_instituicao']) ? $parametros['id_instituicao'] : NULL;
        $id_supervisor = isset($parametros['id_supervisor']) ? $parametros['id_supervisor'] : NULL;
        $nivel = isset($parametros['nivel']) ? $parametros['nivel'] : NULL;
        $turno = isset($parametros['turno']) ? $parametros['turno'] : NULL;

        // Para fazer a lista para o select dos estagios anteriores
        $periodos_total = $this->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => ('Estagiario.periodo'),
            'order' => array('Estagiario.periodo' => 'DESC')
        ));
        // pr($periodo);
        // pr("Período: ", $periodo);
        // Guardo o valor do periodo (incluso quando eh 0) ate que seja selecionado outro periodo
        if ($periodo == NULL) {
            // echo "Período NULL";
            // die("Período NULL");
            $periodo = $this->Session->read("periodo");
            if ($periodo) {
                $condicoes['periodo'] = $periodo;
            }
        } elseif ($periodo == 0) {
            /* Todos os periodos */
            // echo "Período 0";
            // die("Período 0");
            $this->Session->delete("periodo");
        } else {
            // $periodoatual = reset($periodos_total);
            //pr($periodoatual);
            //die("Período atual");
            $this->Session->write("periodo", $periodo);
            $condicoes['periodo'] = $periodo;
        }
        // pr($periodo);
        // die();
        // Se o periodo nõa foi indicado então assume como periodo o periodo atual
        // $periodoatual = reset($periodos_total);
        $this->set('periodoatual', reset($periodos_total));
        // pr($periodoatual);
        // Guardo o valor do id_area ate que seja selecionada outra
        if ($id_area == NULL) {
            $id_area = $this->Session->read("estagiario_id_area");
            if ($id_area) {
                $condicoes['Estagiario.id_area'] = $id_area;
            }
        } elseif ($id_area == 0) {
            $this->Session->delete("estagiario_id_area");
        } else {
            $this->Session->write("estagiario_id_area", $id_area);
            $condicoes['Estagiario.id_area'] = $id_area;
        }

        // Áreas
        $areas = $this->Estagiario->Area->find('list', array(
            'fields' => array('Area.area'),
            'order' => 'Area.area'));

        $this->set('id_area', $id_area);
        $this->set('areas', $areas);

        // Professores
        $professores = $this->Estagiario->Professor->find('list', array(
            'fields' => array('Professor.nome'),
            'order' => array('Professor.nome'))
        );

        // Guardo o valor do id_professor ate que seja selecionado outro
        if ($id_professor == NULL) {
            $id_professor = $this->Session->read("estagiario_id_professor");
            if ($id_professor) {
                $condicoes['Estagiario.id_professor'] = $id_professor;
            }
        } elseif ($id_professor == 0) {
            $this->Session->delete("estagiario_id_professor");
        } else {
            $this->Session->write("estagiario_id_professor", $id_professor);
            $condicoes['Estagiario.id_professor'] = $id_professor;
        }

        $this->set('id_professor', $id_professor);
        $this->set('professores', $professores);

        // Instituicoes
        $instituicoes = $this->Estagiario->Instituicao->find('list', array(
            'fields' => array('Instituicao.instituicao'),
            'order' => array('Instituicao.instituicao'))
        );

        // Guardo o valor do id_instituicao ate que seja selecionado outro
        if ($id_instituicao == NULL) {
            $id_instituicao = $this->Session->read("estagiario_id_instituicao");
            if ($id_instituicao) {
                $condicoes['Estagiario.id_instituicao'] = $id_instituicao;
            }
        } elseif ($id_instituicao == 0) {
            $id_instituicao = $this->Session->delete("estagiario_id_instituicao");
        } else {
            $this->Session->write("estagiario_id_instituicao", $id_instituicao);
            $condicoes['Estagiario.id_instituicao'] = $id_instituicao;
        }

        $this->set('id_instituicao', $id_instituicao);
        $this->set('instituicoes', $instituicoes);

        // Supervisores
        $supervisores = $this->Estagiario->Supervisor->find('list', array(
            'fields' => array('Supervisor.nome'),
            'order' => array('Supervisor.nome')
                )
        );
        // Guardo o valor do id_supervisor ate que seja selecionado outro
        if ($id_supervisor == NULL) {
            $id_supervisor = $this->Session->read("estagiario_id_supervisor");
            if ($id_supervisor) {
                $condicoes['Estagiario.id_supervisor'] = $id_supervisor;
            }
        } elseif ($id_supervisor == 0) {
            $this->Session->delete("estagiario_id_supervisor");
        } else {
            $this->Session->write("estagiario_id_supervisor", $id_supervisor);
            $condicoes['Estagiario.id_supervisor'] = $id_supervisor;
        }

        $this->set('id_supervisor', $id_supervisor);
        $this->set('supervisores', $supervisores);

        // Guardo o valor do nivel de estágio ate que seja selecionado outro
        if ($nivel == NULL) {
            $nivel = $this->Session->read("estagiario_nivel");
            if ($nivel) {
                $condicoes['Estagiario.nivel'] = $nivel;
            }
        } elseif ($nivel == 0) {
            $this->Session->delete("estagiario_nivel");
        } else {
            $this->Session->write("estagiario_nivel", $nivel);
            $condicoes['Estagiario.nivel'] = $nivel;
        }

        $this->set('nivel', $nivel);
        $this->set('nivels', array('niveis' => '1', '2', '3', '4'));

        // Guardo o valor do nivel de estágio ate que seja selecionado outro
        if ($turno == NULL) {
            $turno = $this->Session->read("estagiario_turno");
            if ($turno) {
                $condicoes['Estagiario.turno'] = $turno;
            }
        } elseif ($turno == '0') {
            $this->Session->delete("estagiario_turno");
        } else {
            $this->Session->write("estagiario_turno", $turno);
            $condicoes['Estagiario.turno'] = $turno;
        }

        $this->set('turno', $turno);
        $this->set('turnos', array('turnos' => 'D', 'N'));

        if (isset($condicoes)) {
            // pr($condicoes);
            // die();
        }

        if (isset($condicoes)) {
            $this->set('estagiarios', $this->Paginate($condicoes));
        } else {
            $this->set('estagiarios', $this->Paginate('Estagiario'));
        }

        $this->set('periodo', $periodo);
        $this->set('periodos_todos', $periodos_total);
    }

    public function view($id = NULL) {

        $estagio = $this->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id)));
        // pr($estagio);
        $this->set('estagio', $estagio);
    }

    public function alunorfao() {

        $this->set('orfaos', $this->Estagiario->alunorfao());
    }

    public function edit($id = NULL) {

        // pr($this->data);
        // die('Edit');

        if (empty($this->data)) {

            $estagiario = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.id' => $id),
                'fields' => array('Estagiario.periodo', 'Estagiario.nivel', 'Estagiario.id_professor', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_area', 'Estagiario.nota', 'Estagiario.ch', 'Aluno.nome', 'Instituicao.instituicao', 'Supervisor.nome', 'Professor.nome', 'Area.area')
            ));
            // pr($estagiario);
            // die();

            $aluno = $estagiario['Aluno']['nome'];
            $this->set('aluno', $aluno);

            // Periodos para o select
            $periodos_total = $this->Estagiario->find('list', array(
                'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
                'group' => ('Estagiario.periodo'),
                'order' => ('Estagiario.periodo')
            ));

            // Para acrescenter os próximos periodos carrego a configuracao do planejamento
            $this->loadModel('Configuraplanejamento');
            $periodo_planejamento = $this->Configuraplanejamento->find('all');
            // pr($periodo_planejamento);
            foreach ($periodo_planejamento as $c_periodoplanejamento) {
                // pr($c_periodoplanejamento['Configuraplanejamento']['semestre']);
                $periodos_novo[$c_periodoplanejamento['Configuraplanejamento']['semestre']] = $c_periodoplanejamento['Configuraplanejamento']['semestre'];
            }
            // pr($periodos_novo);
            $semestres = array_unique(array_merge($periodos_total, $periodos_novo));
            // pr($semestres);
            // die();
            $this->set('periodos', $semestres);

            /* Instituicoes para o select. Nao colocar a opcao 0 */
            $this->loadModel('Instituicao');
            $instituicoes = $this->Instituicao->find('list', array(
                'order' => 'Instituicao.instituicao'));

            $instituicoes[0] = "- Selecione -";
            asort($instituicoes);
            // pr($instituicoes);
            $this->set('instituicoes', $instituicoes);
            // die();

            /* Supervisores da instituicao para o select */
            $supervisores = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id' => $estagiario['Estagiario']['id_instituicao'])
            ));
            // pr($supervisores);
            // die();

            /* Crio a lista de supervisores da instituicao para o select */
            if ($supervisores['Supervisor']) {
                foreach ($supervisores['Supervisor'] as $cada_super) {
                    $ordemsuper[$cada_super['id']] = $cada_super['nome'];
                }
            }
            $ordemsuper[0] = "- Seleciona -";
            asort($ordemsuper);
            $this->set('supervisores', $ordemsuper);

            /* Professores para o select */
            $this->loadModel('Professor');
            $professores = $this->Professor->find('list', array(
                'order' => 'Professor.nome'));
            $professores[0] = "- Selecionar -";
            asort($professores);
            $this->set('professores', $professores);

            /* Areas para o select */
            $this->loadModel('Area');
            $areas = $this->Area->find('list', array(
                'order' => 'area'));
            $areas[0] = "- Selecionar -";
            asort($areas);
            $this->set('areas', $areas);

            $this->set('id', $this->Estagiario->id = $id);

            $this->Estagiario->id = $id;

            $this->data = $this->Estagiario->read();
            // pr($this->data);
            // die();
        } else {
            if ($this->Estagiario->save($this->data)) {
                $this->Session->setFlash("Atualizado $id");
                $this->redirect('/Alunos/view/ ' . $this->data['Estagiario']['id_aluno']);
            }
        }
    }

    public function delete($id = NULL) {

        // pr($id);
        $estagiario = $this->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id),
            'fields' => array('Estagiario.id', 'Estagiario.id_aluno', 'Estagiario.registro')
        ));
        // pr($estagiario['Estagiario']['id_aluno']);
        $id_aluno = $estagiario['Estagiario']['id_aluno'];
        // pr($id_aluno);
        // die();

        $this->Estagiario->delete($id);
        $this->Session->setFlash('O registro ' . $id . ' foi excluido.');

        $this->redirect('/Alunos/view/' . $id_aluno);
    }

    /*
     * O id eh o id do Aluno
     */

    public function add($id = NULL) {

        // Para fazer a lista dos estagios anteriores
        $periodos_total = $this->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => ('Estagiario.periodo'),
            'order' => ('Estagiario.periodo')
        ));

        // Para acrescenter os próximos periodos carrego a configuracao do planejamento
        $this->loadModel('Configuraplanejamento');
        $periodo_planejamento = $this->Configuraplanejamento->find('all');
        // pr($periodo_planejamento);
        foreach ($periodo_planejamento as $c_periodoplanejamento) {
            // pr($c_periodoplanejamento['Configuraplanejamento']['semestre']);
            $periodos_novo[$c_periodoplanejamento['Configuraplanejamento']['semestre']] = $c_periodoplanejamento['Configuraplanejamento']['semestre'];
        }
        // pr($periodos_novo);
        $semestres = array_unique(array_merge($periodos_total, $periodos_novo));
        // pr($semestres);
        // die();
        // $this->set('periodos', $semestres);
        // Captura o periodo de estagio atual
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo_atual = $configuracao['Configuracao']['termo_compromisso_periodo'];
        // pr($periodo_atual);
        $periodos_total[$periodo_atual] = $periodo_atual;
        // pr($periodos_total);

        /*
         * O id eh o id do Aluno
         */
        if ($id) {

            // Para capturar o nome do aluno
            $this->set('id_aluno', $id);

            $estagiarios = $this->Estagiario->find('all', array(
                'conditions' => array('Estagiario.id_aluno' => $id)
            ));
            // pr($estagiarios);
            // Não sei se isto eh necessario aqui
            $nivel_periodo_atual = NULL;

            if ($estagiarios) {
                // Calculo o nivel de estagio para o proximo periodo
                foreach ($estagiarios as $c_estagio) {
                    if ($c_estagio['Estagiario']['periodo'] == $periodo_atual) {
                        // echo "Nivel do periodo atual";
                        $nivel_periodo_atual = $c_estagio['Estagiario']['nivel'];
                    } else {
                        $nivel[$c_estagio['Estagiario']['nivel']] = $c_estagio['Estagiario']['nivel'];
                    }
                }
                // Não deveria acontecer, mas se acontecer ...
            } else {
                // echo "Estudante sem estágio: " . $id;
                $this->loadModel('Aluno');
                $estagiario_sem_estagio = $this->Aluno->find('first', array(
                    'conditions' => array('Aluno.id' => $id))
                );
                // pr($estagiario_sem_estagio);
                // die($estagiario_sem_estagio);
            }

            // Ordeno os niveis (estagios anteriores ao periodo atual)
            $ultimo_nivel = NULL;
            if (isset($nivel)) {
                asort($nivel);
                // Passo o valor do ultimo
                $ultimo_nivel = end($nivel);
                // Incremento em hum para o próximo estágio
                $ultimo_nivel = $ultimo_nivel + 1;
                // Se eh maior de 4 deixo em 4
                if ($ultimo_nivel > 4) {
                    $ultimo_nivel = 4;
                }
                // Se nao existe o nivel entao eh 1
            } else {
                $ultimo_nivel = 1;
            }
            // Se o nivel eh do periodo atual entao nao muda
            if ($nivel_periodo_atual)
                $ultimo_nivel = $nivel_periodo_atual;
            // pr($ultimo_nivel);

            $this->set('estagiarios', $estagiarios);
            $this->set('proximo_nivel', $ultimo_nivel);
        }

        /* Para fazer o select dos alunos */
        $this->loadModel('Aluno');
        $alunos = $this->Aluno->find('list', array('order' => 'Aluno.nome'));
        $this->set('alunos', $alunos);

        /* Select das instituicoes. Nao colocar a opcao zero */
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', array('order' => 'Instituicao.instituicao'));
        $this->set('instituicoes', $instituicoes);

        /* Select dos supervisores */
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', array('order' => 'Supervisor.nome'));
        // $supervisores[0] = '- Seleciona -';
        // asort($supervisores);
        $this->set('supervisores', $supervisores);

        /* Select dos professores */
        $this->loadModel('Professor');
        $professores = $this->Professor->find('list', array(
            'order' => array('Professor.nome'),
            'conditions' => array('motivoegresso' => '')));
        // $professores[0] = '- Seleciona -';
        // asort($professores);
        $this->set('professores', $professores);

        /* Select das areas tematicas */
        $this->loadModel('Area');
        $areas = $this->Area->find('list', array(
            'order' => 'area'));
        // $areas[0] = '- Seleciona -';
        // asort($areas);
        $this->set('areas', $areas);

        $this->set('periodos', $semestres);
        $this->set('periodo_atual', $periodo_atual);
        if (isset($estagiario_sem_estagio)) {
            $this->set('estagiario_sem_estagio', $estagiario_sem_estagio);
        }
        if ($this->data) {
            /*
              $aluno = $this->Aluno->findById($this->data['Estagiario']['id_aluno']);
              $this->data['Estagiario']['registro'] = $aluno['Aluno']['registro'];
             */
            if ($this->Estagiario->save($this->data, array('validates' => TRUE))) {

                $this->Session->setFlash('Registro de estágio inserido!');
                $this->redirect('/Alunos/view/' . $this->data['Estagiario']['id_aluno']);
            }
        }
    }

    public function add_estagiario() {

        // Configure::write('debug', '2');
        if (!empty($this->data)) {

            // Tiro os carateres de sublinhado
            $sanitarize_registro = (int) trim($this->data['Estagiario']['registro']);
            // pr(strlen($sanitarize_registro));
            if (strlen($sanitarize_registro) < 9) {
                $this->Session->setFlash('Número inválido');
                $this->redirect('/Estagiarios/add_estagiario');
            }

            $registro = $this->data['Estagiario']['registro'];
            // pr($registro);
            // Captura o periodo de estagio
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

            // Com o periodo e o registro consulto a tabela de estagiarios
            $periodo_estagio = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $registro),
                'fields' => array('Estagiario.id', 'Estagiario.id_aluno', 'Estagiario.registro')));



            if (empty($periodo_estagio)) {
                // echo "Aluno  novo sem estágio";
                $this->Session->setFlash("Aluno novo sem cadastro");
                $this->redirect('/alunos/add/' . $registro);
            } else {

                $this->redirect('/alunos/view/' . $periodo_estagio['Estagiario']['id_aluno']);
            }
        }
    }

}

?>
