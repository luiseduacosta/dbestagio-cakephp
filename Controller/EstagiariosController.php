<?php

class EstagiariosController extends AppController {

    public $name = 'Estagiarios';
    public $components = array('Auth');
    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Estagiario.nome' => 'asc')
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
            $this->redirect('/Userestagios/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $parametros = $this->params['named'];
        // pr($parametros);
        // pr($parametros['periodo']);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $ajustecurricular2020 = isset($parametros['ajustecurricular2020']) ? $parametros['ajustecurricular2020'] : NULL;        
        $areaestagio_id = isset($parametros['areaestagio_id']) ? $parametros['areaestagio_id'] : NULL;
        $aluno_id = isset($parametros['aluno_id']) ? $parametros['aluno_id'] : NULL;
        $docente_id = isset($parametros['docente_id']) ? $parametros['docente_id'] : NULL;
        $instituicao_id = isset($parametros['instituicao_id']) ? $parametros['instituicao_id'] : NULL;
        $supervisor_id = isset($parametros['supervisor_id']) ? $parametros['supervisor_id'] : NULL;
        $nivel = isset($parametros['nivel']) ? $parametros['nivel'] : NULL;
        $turno = isset($parametros['turno']) ? $parametros['turno'] : NULL;

        // pr("Periodo1 " . $periodo);
        // pr($parametros['periodo']);

        $condicoes = NULL;

        // Para fazer a lista para o select dos estagios anteriores
        $periodos_total = $this->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => ('Estagiario.periodo'),
            'order' => array('Estagiario.periodo' => 'DESC')
        ));

        // pr($periodos_total);
        // Guardo o valor do periodo (incluso quando eh 0) ate que seja selecionado outro periodo
        if ($periodo == NULL) {
            // echo "Período1 NULL" . "<br>";
            // die("Período NULL");
            $periodo = $this->Session->read("periodo");
            if ($periodo) {
                $condicoes['periodo'] = $periodo;
            }
        } elseif ($periodo == 0) {
            /* Todos os periodos */
            // echo "Período2 0" . "<br>";
            // die("Período 0");
            $this->Session->delete("periodo");
        } elseif ($periodo) {
            // echo "Período3 " . $periodo . "<br>";
            $this->Session->write("periodo", $periodo);
            $condicoes['periodo'] = $periodo;
        } else {
            $periodo = reset($periodos_total);
            $this->Session->write("periodo", $periodo);
            $condicoes['periodo'] = $periodo;
            // pr($periodo);
            //die("Período atual");
        }

        // pr('Período2 ' . $periodo);
        // die();
        // Guardo o valor do areaestagio_id ate que seja selecionada outra
        if ($areaestagio_id == NULL) {
            $areaestagio_id = $this->Session->read("estagiario_areaestagio_id");
            if ($areaestagio_id) {
                $condicoes['Estagiario.areaestagio_id'] = $areaestagio_id;
            }
        } elseif ($areaestagio_id == 0) {
            $this->Session->delete("estagiario_areaestagio_id");
        } else {
            $this->Session->write("estagiario_areaestagio_id", $areaestagio_id);
            $condicoes['Estagiario.areaestagio_id'] = $areaestagio_id;
        }

        // Áreas
        $areaestagios = $this->Estagiario->Areaestagio->find('list', array(
            'fields' => array('Areaestagio.area'),
            'order' => 'Areaestagio.area'));
        // pr($areas);
        // die();
        $this->set('areaestagio_id', $areaestagio_id);
        $this->set('areaestagios', $areaestagios);

        // Professores
        $professores = $this->Estagiario->Professor->find('list', array(
            'fields' => array('Professor.id', 'Professor.nome'),
            'order' => array('Professor.nome'))
        );
        // pr($professores);
        // die();
        // Guardo o valor do professor_id ate que seja selecionado outro
        if ($docente_id == NULL) {
            $docente_id = $this->Session->read("estagiario_professor_id");
            if ($docente_id) {
                $condicoes['Estagiario.docente_id'] = $docente_id;
            }
        } elseif ($docente_id == 0) {
            $this->Session->delete("estagiario_professor_id");
        } else {
            $this->Session->write("estagiario_professor_id", $docente_id);
            $condicoes['Estagiario.docente_id'] = $docente_id;
        }
        // echo $docente_id;
        // pr($professores);
        // die();

        $this->set('docente_id', $docente_id);
        $this->set('professores', $professores);

        // Instituicoes
        $instituicoes = $this->Estagiario->Instituicao->find('list', array(
            'fields' => array('Instituicao.instituicao'),
            'order' => array('Instituicao.instituicao'))
        );

        // Guardo o valor do instituicao_id ate que seja selecionado outro
        if ($instituicao_id == NULL) {
            $instituicao_id = $this->Session->read("estagiario_instituicao_id");
            if ($instituicao_id) {
                $condicoes['Estagiario.instituicao_id'] = $instituicao_id;
            }
        } elseif ($instituicao_id == 0) {
            $instituicao_id = $this->Session->delete("estagiario_instituicao_id");
        } else {
            $this->Session->write("estagiario_instituicao_id", $instituicao_id);
            $condicoes['Estagiario.instituicao_id'] = $instituicao_id;
        }

        $this->set('instituicao_id', $instituicao_id);
        $this->set('instituicoes', $instituicoes);

        // Supervisores
        $supervisores = $this->Estagiario->Supervisor->find('list', array(
            'fields' => array('Supervisor.nome'),
            'order' => array('Supervisor.nome')
                )
        );
        // Guardo o valor do supervisor_id ate que seja selecionado outro
        if ($supervisor_id == NULL) {
            $supervisor_id = $this->Session->read("estagiario_supervisor_id");
            if ($supervisor_id) {
                $condicoes['Estagiario.supervisor_id'] = $supervisor_id;
            }
        } elseif ($supervisor_id == 0) {
            $this->Session->delete("estagiario_supervisor_id");
        } else {
            $this->Session->write("estagiario_supervisor_id", $supervisor_id);
            $condicoes['Estagiario.supervisor_id'] = $supervisor_id;
        }
        // echo $supervisor_id;
        // pr($supervisores);
        // die();

        $this->set('supervisor_id', $supervisor_id);
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
        $this->set('nivels', array('niveis' => '1', '2', '3', '4', '9'));

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
            pr($condicoes);
            // die();
        }
// die($condicoes);
        if (isset($condicoes)) {
            $this->set('estagiarios', $this->Paginate($condicoes));
        } else {
            $this->set('estagiarios', $this->Paginate('Estagiario'));
        }

        $this->set('periodo', $periodo);
        $this->set('periodos_todos', $periodos_total);
    }

    public function view($id = NULL) {

        if (isset($id)) {
            $estagio = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.id' => $id)));
        } else {
            $this->Session->setFlash(__("Sem parâmetros para executar a função"));
            $this->redirect('/Estudantes/index');
        }
        // pr($estagio);

        $estagios = $this->Estagiario->find('all', [
            'conditions' => ['Estagiario.registro' => $estagio['Estagiario']['registro']]
        ]);
        // pr($estagios);
        if (!empty($estagios)) {
            $this->set('estagios', $estagios);
        }
        $this->set('estagio', $estagio);
    }

    public function alunorfao() {

        $this->set('orfaos', $this->Estagiario->alunorfao());
    }

    public function edit($id = NULL) {

        // pr($this->request->data);
        // echo $id . "<br>";
        // die('Edit');

        if (empty($this->request->data)) {

            $estagiario = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.id' => $id),
                'fields' => array('Estagiario.id', 'Estagiario.registro, Estagiario.periodo', 'Estagiario.nivel', 'Estagiario.docente_id', 'Estagiario.instituicao_id', 'Estagiario.supervisor_id', 'Estagiario.areaestagio_id', 'Estagiario.nota', 'Estagiario.ch', 'Aluno.nome', 'Instituicao.instituicao', 'Supervisor.nome', 'Professor.nome', 'Areaestagio.area')
            ));
            // pr($estagiario);
            // die('estagiario');

            $this->loadModel('Estudante');
            $aluno = $this->Estudante->find('first', [
                'fields' => ['Estudante.nome'],
                'conditions' => ['Estudante.registro' => $estagiario['Estagiario']['registro']]
            ]);
            // pr($aluno);
            // die('aluno');
            $alunonome = $aluno['Estudante']['nome'];
            $this->set('aluno', $alunonome);

            // Periodos para o select
            $periodos_total = $this->Estagiario->find('list', array(
                'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
                'group' => ('Estagiario.periodo'),
                'order' => ('Estagiario.periodo')
            ));
            // pr($periodos_total);
            // die('periodos_total');
            // Para acrescenter os próximos periodos carrego a configuracao do planejamento
            $this->loadModel('Configuraplanejamento');
            $periodo_planejamento = $this->Configuraplanejamento->find('all');
            // pr($periodo_planejamento);
            foreach ($periodo_planejamento as $c_periodoplanejamento) {
                // pr($c_periodoplanejamento['Configuraplanejamento']['semestre']);
                $periodos_novo[$c_periodoplanejamento['Configuraplanejamento']['semestre']] = $c_periodoplanejamento['Configuraplanejamento']['semestre'];
            }
            // pr($periodos_novo);
            // die('periodo_novo');

            $semestres = array_unique(array_merge($periodos_total, $periodos_novo));
            // pr($semestres);
            // die();
            $this->set('periodos', $semestres);

            /* Instituicoes para o select. Nao colocar a opcao 0 */
            $this->loadModel('Instituicao');
            $instituicoes = $this->Instituicao->find('list', array(
                'order' => 'Instituicao.instituicao'));
            // pr($instituicoes);
            // die('instituicoes');
            $this->set('instituicoes', $instituicoes);

            /* Supervisores da instituicao para o select */
            $this->loadModel('Supervisor');
            $supervisores = $this->Supervisor->find('list', array(
                'order' => ['Supervisor.nome']
            ));
            // pr($supervisores);
            // die('supervisores');
            $this->set('supervisores', $supervisores);

            /* Professores para o select */
            $this->loadModel('Professor');
            $professores = $this->Professor->find('list', array(
                'order' => 'Professor.nome'));
            // pr($professores);
            // die('professores');
            $this->set('professores', $professores);

            /* Areas para o select */
            $this->loadModel('Areaestagio');
            $areas = $this->Areaestagio->find('list', array(
                'order' => 'area'));
            // pr($areas);
            // die('areas');
            $this->set('areas', $areas);

            // $this->set('id', $this->Estagiario->id = $id);

            $this->Estagiario->id = $id;

            $this->request->data = $this->Estagiario->read();
            // pr($this->request->data);
            // die('this->request->data');
        } else {
            $this->request->data['Estagiario']['id'] = $id;
            // pr($this->request->data);
            // die('save');
            if ($this->Estagiario->save($this->request->data)) {
                $this->Session->setFlash(__("Atualizado $id"));
                $this->redirect('/Estagiarios/view/' . $this->Estagiario->id);
            } else {
                $this->Session->setFlash(__("Aconteceu um problema $id"));
                die('Não foi possível atualizar');
            }
        }
    }

    public function delete($id = NULL) {

        // pr($id);
        $estagiario = $this->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id),
            'fields' => array('Estagiario.id', 'Estagiario.aluno_id', 'Estagiario.registro')
        ));
        // pr($estagiario['Estagiario']['aluno_id']);
        $aluno_id = $estagiario['Estagiario']['aluno_id'];
        // pr($aluno_id);
        // die();

        $this->Estagiario->delete($id);
        $this->Session->setFlash('O registro ' . $id . ' foi excluido.');

        $this->redirect('/Estudantes/view/registro:' . $estagiario['Estagiario']['registro']);
    }

    /*
     * O id eh o id do Aluno
     */

    public function add($id = NULL) {

        $parametros = $this->params['named'];
        $registro = isset($parametros['registro']) ? $parametros['registro'] : NULL;

        // $registro = 100100100;
        // Para fazer a lista dos períodos anteriores
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
        // Captura o periodo_atual de estagio
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo_atual = $configuracao['Configuracao']['termo_compromisso_periodo'];
        // pr($periodo_atual);
        // die();
        $periodos_total[$periodo_atual] = $periodo_atual;
        // pr($periodos_total);
        // die();

        if ($id) {
            $estagiarios = $this->Estagiario->find('all', array(
                'conditions' => array('Estagiario.id' => $id),
                'order' => ['Estagiario.nivel' => 'ASC', 'Estagiario.periodo' => 'ASC']
            ));
        } elseif ($registro) {
            $estagiarios = $this->Estagiario->find('all', [
                'conditions' => ['Estagiario.registro' => $registro],
                'order' => ['Estagiario.nivel' => 'ASC', 'Estagiario.periodo' => 'ASC']
            ]);
        }
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($estagiarios);
        // die('estagiarios');

        if ($estagiarios) {

            // Se o nivel eh do periodo atual entao nao muda
            if ($estagiarios[array_key_last($estagiarios)]['Estagiario']['periodo'] == $periodo_atual) {
                // echo "Atualização do níviel de estágio" . "<br>";
                $ultimo_nivel = $estagiarios[array_key_last($estagiarios)]['Estagiario']['nivel'];
            } else {
                $ultimo_nivel = NULL;
                // echo 'Mudança de nível de estágio' . "<br>";
                $ultimo_nivel = $estagiarios[array_key_last($estagiarios)]['Estagiario']['nivel'];
                // Incremento em 1 para o próximo estágio
                $ultimo_nivel = $ultimo_nivel + 1;
                /* Verifico se é ajustecurricular2020 */
                
                if ($estagiarios[array_key_last($estagiarios)]['Estagiario']['ajustecurricular2020'] === 0) {
                    $ultimoestagio = 4;
                } elseif ($estagiarios[array_key_last($estagiarios)]['Estagiario']['ajustecurricular2020'] === 1) {
                    $ultimoestagio = 3;
                } else {
                    $ultimoestagio = 4;
                }
                // Se eh maior que $ultimoestagio coloco 9 (estágio não obrigatório)
                if ($ultimo_nivel > $ultimoestagio) {
                    $ultimo_nivel = 9;
                } else {    // Se nao existe o nivel entao eh 1
                    $ultimo_nivel = 1;
                }
            }
            // die('mudança do nível de estágio');
            /* Isto não pode acontecer nesta consulta? */
        } else {
            // echo "Estudante sem estágio: " . $id;
            $this->loadModel('Estudante');
            $estagiario_sem_estagio = $this->Estudante->find('first', array(
                'conditions' => array('Estudante.registro' => $registro))
            );
            // pr($estagiario_sem_estagio);
            // die($estagiario_sem_estagio);
        }

        $this->set('estagiarios', $estagiarios);
        $this->set('proximo_nivel', $ultimo_nivel);

        /* Para fazer o select dos alunos */
        $this->loadModel('Estudante');
        $alunos = $this->Estudante->find('list', array('order' => 'Estudante.nome'));
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
        $this->loadModel('Areaestagio');
        $areas = $this->Areaestagio->find('list', array(
            'order' => 'area'));
        // $areas[0] = '- Seleciona -';
        // asort($areas);
        $this->set('areas', $areas);

        $this->set('periodos', $semestres);
        $this->set('periodo_atual', $periodo_atual);
        if (isset($estagiario_sem_estagio)) {
            $this->set('estagiario_sem_estagio', $estagiario_sem_estagio);
        }
        // pr($this->request->data);
        // die();
        if ($this->request->data) {
            /*
              $aluno = $this->Aluno->findById($this->data['Estagiario']['aluno_id']);
              $this->data['Estagiario']['registro'] = $aluno['Aluno']['registro'];
             */
            if ($this->Estagiario->save($this->data, array('validates' => TRUE))) {

                $this->Session->setFlash(__('Registro de estágio inserido!'));
                $this->redirect('/Estudantes/view/registro:' . $this->request->data['Estagiario']['registro']);
            }
        }
    }

    public function add_estagiario() {

        // Configure::write('debug', '2');
        if (!empty($this->request->data)) {
            // pr($this->request->data);
            // die();
            // Tiro os carateres de sublinhado
            $sanitarize_registro = (int) trim($this->request->data['Estagiario']['registro']);
            // pr(strlen($sanitarize_registro));
            if (strlen($sanitarize_registro) < 9) {
                $this->Session->setFlash(__('Número inválido'));
                $this->redirect('/Estagiarios/add_estagiario');
            }

            $registro = $this->request->data['Estagiario']['registro'];
            // pr($registro);
            // die('registro');
            // Captura o periodo de estagio
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

            // Com o periodo e o registro consulto a tabela de estagiarios
            $periodo_estagio = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $registro),
                'fields' => array('Estagiario.id', 'Estagiario.aluno_id', 'Estagiario.registro')));

            if (empty($periodo_estagio)) {
                // echo "Aluno  novo sem estágio";
                $this->Session->setFlash(__("Estudante sem cadastro"));
                $this->redirect('/Estudantes/add/registro:' . $registro);
            } else {
                $this->redirect('/Estudantes/view/registro:' . $registro);
            }
        }
    }

    public function declaracaoestagio($id, $nivel) {

        // $id = 100100101;
        $estagiorealizado = $this->Estagiario->find('first', [
            'conditions' => ['Estagiario.id' => $id, 'Estagiario.nivel' => $nivel]
        ]);
        // pr($estagiorealizado);
        // die('estagiario');
        $this->set('estagiorealizado', $estagiorealizado);
        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

    public function estudantes() {

        $estagiarios = $this->Estagiario->find('all', [
            'fields' => ['Estagiario.registro']
        ]);
        // pr($estagiarios);
        $this->loadModel('Estudante');
        foreach ($estagiarios as $c_estagiario) {
            pr($c_estagiario['Estagiario']['registro']);
            $estudante = $this->Estudante->find('first', [
                'conditions' => ['Estudante.registro' => $c_estagiario['Estagiario']['registro']]
            ]);
            // pr($estudante);
            if ($estudante) {
                $query = "UPDATE estagiarios as Estagiario "
                        . "SET Estagiario.estudante_id = " . $estudante['Estudante']['id']
                        . " WHERE Estagiario.registro = " . $estudante['Estudante']['registro'];
                pr($query);
                $this->Estagiario->query($query);
            } else {
                echo ' Estudante sem estágio ' . "<br>";
            }
            // die();
        }
        die();
    }

    public function alunos() {

        $estagiarios = $this->Estagiario->find('all', [
            'fields' => ['Estagiario.registro']
        ]);
        // pr($estagiarios);
        $this->loadModel('Aluno');
        foreach ($estagiarios as $c_estagiario) {
            pr($c_estagiario['Estagiario']['registro']);
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $c_estagiario['Estagiario']['registro']]
            ]);
            // pr($aluno);
            if ($aluno) {
                $query = "UPDATE estagiarios as Estagiario "
                        . "SET Estagiario.aluno_id = " . $estudante['Aluno']['id']
                        . " WHERE Estagiario.registro = " . $estudante['Aluno']['registro'];
                pr($query);
                $this->Estagiario->query($query);
            } else {
                echo ' Aluno sem estágio ' . "<br>";
            }
            // die();
        }
        die();
    }

}

?>
