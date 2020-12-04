<?php

class InstituicaoestagiosController extends AppController {

    public $name = "Instituicaoestagios";
    public $helpers = ['Text'];
    public $components = array('Auth');
    public $paginate = [
        'limit' => 25,
        'order' => ['Instituicaoestagio.instituicao']
    ];

    public function beforeFilter() {
        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash(__("Administrador"), "flash_notification");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'lista', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash(__("Estudante"), "flash_notification");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash(__("Professor"), "flash_notification");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash(__("Professor/Supervisor"), "flash_notification");
        } else {
            $this->Session->setFlash(__("Não autorizado"), "flash_notification");
            $this->redirect('/Userestagios/login/');
        }
    }

    public function index() {

        $parametros = $this->params['named'];
        // print_r($parametros);
        $areainstituicao_id = isset($parametros['areainstituicao_id']) ? $parametros['areainstituicao_id'] : null;
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : null;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;
        $limite = isset($parametros['limite']) ? $parametros['limite'] : 10;

        // pr($periodo);

        $todosPeriodos = $this->Instituicaoestagio->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));

        if ($periodo) {

            if ($areainstituicao_id) {
                $conditions = ['Instituicaoestagio.areainstituicao_id' => $areainstituicao_id, 'Estagiario.periodo' => $periodo];
            } elseif ($natureza) {
                $conditions = ['Instituicaoestagio.natureza' => $natureza, 'Estagiario.periodo' => $periodo];
            } else {
                $conditions = ['Estagiario.periodo' => $periodo];
            }
        } else {

            if ($areainstituicao_id) {
                $conditions = ['Instituicaoestagio.areainstituicao_id' => $areainstituicao_id];
            } elseif ($natureza) {
                $conditions = ['Instituicaoestagio.natureza' => $natureza];
            } else {
                $conditions = null;
            }
        }
        // pr($conditions);
        // die('conditions');

        if (empty($conditions)) {
            $this->Paginator->settings = ['Instituicaoestagio' =>
                ['order' => 'Instituicaoestagio.instituicao'],
                ['contain' => 'Estagiario']
            ];
        }

        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        $this->set('limite', $limite);
        $this->set('instituicoes', $this->Paginate('Instituicaoestagio'));
    }

    public function periodo($id = null) {

        $parametros = $this->params['named'];
        // print_r($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'instituicao';

        $todososperiodos = $this->todososperiodos();
        if (empty($periodo)):
            $periodo = end($todososperiodos);
        endif;

        $this->loadModel('Estagiario');
        $this->Estagiario->recursive = -1;
        $instituicoes = $this->Estagiario->find('all', [
            'fields' => ['instituicaoestagio_id', 'periodo'],
            'conditions' => ['Estagiario.periodo' => $periodo],
            'group' => 'instituicaoestagio_id'
        ]);

        $i = 0;
        foreach ($instituicoes as $c_instituicao) {
            // pr($c_instituicao);
            $instituicao = $this->Instituicaoestagio->find('first', [
                'fields' => ['instituicao', 'expira', 'area', 'natureza'],
                'conditions' => ['Instituicaoestagio.id' => $c_instituicao['Estagiario']['instituicaoestagio_id']]
            ]);
            // pr($instituicao);
            $resultado[$i]['instituicao_id'] = $instituicao['Instituicaoestagio']['id'];
            $resultado[$i]['instituicao'] = $instituicao['Instituicaoestagio']['instituicao'];
            $resultado[$i]['expira'] = $instituicao['Instituicaoestagio']['expira'];
            $resultado[$i]['areainstituicao'] = $instituicao['Instituicaoestagio']['area'];
            $resultado[$i]['natureza'] = $instituicao['Instituicaoestagio']['natureza'];

            if ($instituicao['Estagiario']):
                $resultado[$i]['q_estagiarios'] = count($instituicao['Estagiario']);
            else:
                $resultado[$i]['q_estagiarios'] = null;
            endif;
            if ($instituicao['Supervisor']):
                $resultado[$i]['q_supervisores'] = count($instituicao['Supervisor']);
            else:
                $resultado[$i]['q_supervisores'] = null;
            endif;
            if ($instituicao['Mural']):
                $resultado[$i]['q_murales'] = count($instituicao['Mural']);
                $resultado[$i]['ultimomural_id'] = $instituicao['Mural'][array_key_last($instituicao['Mural'])]['id'];
            else:
                $resultado[$i]['q_murales'] = null;
                $resultado[$i]['ultimomural_id'] = null;
            endif;
            if ($instituicao['Visita']):
                $resultado[$i]['q_visitas'] = $instituicao['Visita'][array_key_last($instituicao['Visita'])]['data'];
            else:
                $resultado[$i]['q_visitas'] = null;
            endif;
            $i++;
        }

        array_multisort(array_column($resultado, $ordem), $resultado);
        // pr($resultado);
        // die('resultado');
        $this->set('periodo', $periodo);
        $this->set('todososperiodos', $todososperiodos);
        $this->set('instituicoes', $resultado);
    }

    public function add() {

        $area_instituicao = $this->Instituicaoestagio->Areainstituicao->find('list', array(
            'order' => 'Areainstituicao.area'));
        // pr($area_instituicao);
        // die();
        $this->set('id_area_instituicao', $area_instituicao);

        /* Passo os meses em português */
        $this->set('meses', $this->meses());
        // pr($meses);
        // die("meses");
        // pr($this->request->data);
        if ($this->request->data) {
            if ($this->Instituicaoestagio->save($this->request->data)) {
                // debug($this->Model->validationErrors);
                $this->Session->setFlash(__('Dados da instituição inseridos!'), "flash_notification");
                $this->redirect('/Instituicaoestagios/view/' . $this->Instituicaoestagio->id);
            }
        }
    }

    public function view($id = null) {

        $this->Instituicaoestagio->contain('Visita', 'Areainstituicao', 'Supervisor', 'Estagiario');
        $instituicao = $this->Instituicaoestagio->find('first', [
            'conditions' => ['Instituicaoestagio.id' => $id],
            'order' => 'Instituicaoestagio.instituicao']);
        // pr($instituicao['Estagiario']);
        // die('instituicao');

        if ($instituicao['Estagiario']):
            $i = 0;
            $this->loadModel('Estudante');
            foreach ($instituicao['Estagiario'] as $estagiarios):
                // pr($estagiarios['registro']);
                $estudantes = $this->Estudante->find('first', [
                    'fields' => ['Estudante.nome', 'Estudante.registro', 'Estudante.id'],
                    'conditions' => ['Estudante.registro' => $estagiarios['registro']],
                    'order' => ['Estudante.nome']
                        ]
                );
                // pr($estudantes);
                // die('estudantes');
                $estudanteestagiario[$i]['nome'] = $estudantes['Estudante']['nome'];
                $estudanteestagiario[$i]['registro'] = $estudantes['Estudante']['registro'];
                $estudanteestagiario[$i]['id'] = $estudantes['Estudante']['id'];
                $estudanteestagiario[$i]['periodo'] = $estagiarios['periodo'];
                $i++;
            endforeach;
            // pr($estudanteestagiario);
            array_multisort(array_column($estudanteestagiario, 'nome'), $estudanteestagiario);
            // pr($estudanteestagiario);
            $this->set('estudantes', $estudanteestagiario);
        endif;

        /* Para acrescentar um supervisor */
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', [
            'order' => ['Supervisor.nome']]);
        // pr($supervisores);
        // die('supervisores');

        $this->set('supervisores', $supervisores);

        $this->Instituicaoestagio->recursive = -1;
        $proximo = $this->Instituicaoestagio->find('neighbors', [
            'field' => 'instituicao', 'value' => $instituicao['Instituicaoestagio']['instituicao']
        ]);
        // pr($proximo);
        if ($proximo['next']) {
            $this->set('registro_next', $proximo['next']['Instituicaoestagio']['id']);
        } else {
            $this->set('registro_prev', $proximo['prev']['Instituicaoestagio']['id']);
        }
        if ($proximo['prev']) {
            $this->set('registro_prev', $proximo['prev']['Instituicaoestagio']['id']);
        } else {
            $this->set('registro_prev', $proximo['next']['Instituicaoestagio']['id']);
        }
        $this->set('instituicao', $instituicao);
    }

    public function edit($id = null) {

        $this->Instituicaoestagio->id = $id;

        $this->set('meses', $this->meses());
        // pr($meses);
        // die("meses");

        $area_instituicao = $this->Instituicaoestagio->Areainstituicao->find('list', array(
            'order' => 'Areainstituicao.area'
        ));

        $this->set('area_instituicao', $area_instituicao);

        if (empty($this->request->data)) {
            $this->request->data = $this->Instituicaoestagio->read();
        } else {
            if ($this->Instituicaoestagio->save($this->request->data)) {
                // print_r($id);
                $this->Session->setFlash(__("Atualizado"), "flash_notification");
                $this->redirect('/Instituicaoestagios/view/' . $id);
            }
        }
    }

    public function delete($id = null) {
        $instituicao = $this->Instituicaoestagio->find('first', array(
            'conditions' => array('Instituicaoestagio.id' => $id)
        ));

        $murais = $instituicao['Mural'];
        $supervisores = $instituicao['Supervisor'];
        $alunos = $instituicao['Estagiario'];

        if ($murais) {
            // die(pr($murais[0]['id']));

            $this->Session->setFlash(__('Há murais vinculados com esta instituição'), "flash_notification");
            $this->redirect('/Muralestagios/view/' . $murais[0]['id']);
        } elseif ($supervisores) {
            $this->Session->setFlash(__('Há supervisores vinculados com esta instituição'), "flash_notification");
            $this->redirect('/Instituicaoestagios/view/' . $id);
        } elseif ($alunos) {
            $this->Session->setFlash(__('Há alunos estagiários vinculados com esta instituição'), "flash_notification");
            $this->redirect('/Instituicaoestagios/view/' . $id);
        } else {
            $this->Instituicaoestagio->delete($id);
            $this->Session->setFlash(__('Registro excluído'), "flash_notification");
            $this->redirect('/Instituicaoestagios/index/');
        }
    }

    public function deleteassociacao($id = null) {

        $id_superinstituicao = $this->Instituicaoestagio->InstituicaoestagioSupervisor->find('first',
                array('conditions' => 'InstituicaoestagioSupervisor.id = ' . $id));
        // pr($id_superinstituicao);
        // die();

        $this->Instituicaoestagio->InstituicaoestagioSupervisor->delete($id);

        $this->Session->setFlash(__("Supervisor excluido da instituição"), "flash_notification");
        $this->redirect('/Instituicaoestagios/view/' . $id_superinstituicao['InstituicaoestagioSupervisor']['instituicaoestagio_id']);
    }

    public function addassociacao() {

        if ($this->request->data) {
            // pr($this->request->data);
            // die();
            if ($this->Instituicaoestagio->InstituicaoestagioSupervisor->save($this->request->data)) {
                $this->Session->setFlash(__('Dados inseridos'), "flash_notification");
                $this->redirect('/Instituicaoestagios/view/' . $this->request->data['InstituicaoestagioSupervisor']['instituicaoestagio_id']);
            }
        }
    }

    public function busca($id = null) {

        if ($id) {
            $this->request->data['Instituicaoestagio']['instituicao'] = $id;
        }

        if (isset($this->request->data['Instituicaoestagio']['instituicao'])):
            if ($this->request->data['Instituicaoestagio']['instituicao']) {
                $condicao = array('Instituicaoestagio.instituicao like' => '%' . $this->data['Instituicaoestagio']['instituicao'] . '%');
                $instituicoes = $this->Instituicaoestagio->find('all', array('conditions' => $condicao, 'order' => 'Instituicaoestagio.instituicao'));

                // Nenhum resultado
                if (empty($instituicoes)) {
                    $this->Session->setFlash(__("Não foram encontrados registros"), "flash_notification");
                } else {
                    $this->set('instituicoes', $instituicoes);
                    $this->set('busca', $this->data['Instituicaoestagio']['instituicao']);
                }
            }
        endif;
    }

    /*
     * Seleciona supervisor em funcao da selecao da instituicao de estagio
     */

    public function seleciona_supervisor($id = null) {
        
        // pr($id);
        $instituicao_id = $this->data['Muralinscricao']['instituicaoestagio_id'];
        // $instituicao_id = $id;
        // pr($instituicao_id);
        // die('instituicao_id');
        if ($instituicao_id != 0) {
            $supervisoresinstituicao = $this->Instituicaoestagio->query('SELECT Supervisor.id, Supervisor.nome FROM instituicaoestagios AS Instituicaoestagio '
                    . 'LEFT JOIN instituicaoestagio_supervisor AS InstituicaoestagioSupervisor ON Instituicaoestagio.id = InstituicaoestagioSupervisor.instituicaoestagio_id '
                    . 'LEFT JOIN supervisores AS Supervisor ON InstituicaoestagioSupervisor.supervisor_id = Supervisor.id '
                    . 'WHERE Instituicaoestagio.id = ' . $instituicao_id);
            // pr($supervisoresinstituicao);
            // die('supervisoresinstituicao');
            if ($supervisoresinstituicao) {
                $super = null;
                foreach ($supervisoresinstituicao as $c_supervisor) {
                    // pr($c_supervisor['Supervisor']);
                    $supervisores[$c_supervisor['Supervisor']['id']] = $c_supervisor['Supervisor']['id'];
                    $supervisores[$c_supervisor['Supervisor']['id']] = $c_supervisor['Supervisor']['nome'];
                }
                // pr($supervisores);
                // die('supervisores');
            }
        }
        $supervisores[0] = '- Seleciona supervisor -';
        asort($supervisores);
        // pr($supervisores);
        // die('supervisores');
        $this->set('supervisores', $supervisores);
        $this->layout = 'ajax';
        // printf($supervisores);
        // pr($supervisores);
        // die("super");
        // return $super;
    }

    public function natureza() {

        $parametros = $this->params['named'];
        // pr($parametros);
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : null;
        $this->Instituicaoestagio->recursive = -1;
        $natureza = $this->Instituicaoestagio->find('all', [
            'fields' => ['Instituicaoestagio.natureza', "count('Instituicaoestagio.natureza') as qnatureza"],
            'order' => ['Instituicaoestagio.natureza'],
            'group' => 'Instituicaoestagio.natureza'
                ]
        );
        // die();
        $this->set('natureza', $natureza);
    }

    public function listainstituicao() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->Instituicaoestagio->recursive = -1;
            $resultado = $this->Instituicaoestagio->find('all', array(
                'fields' => array('Instituicaoestagio.instituicao'),
                'conditions' => array('Instituicaoestagio.instituicao LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicaoestagio.instituicao')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicaoestagio']['instituicao'] . "\n";
            }
        }
    }

    public function listanatureza() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->Instituicaoestagio->recursive = -1;
            $resultado = $this->Instituicaoestagio->find('all', array(
                'fields' => array('Instituicaoestagio.natureza'),
                'conditions' => array('Instituicaoestagio.natureza LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicaoestagio.natureza')
            ));
            foreach ($resultado as $q_resultado) {
                echo htmlspecialchars($q_resultado['Instituicaoestagio']['natureza']) . "\n";
            }
        }
    }

    public function listabairro() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->Instituicaoestagio->recursive = -1;
            $resultado = $this->Instituicaoestagio->find('all', array(
                'fields' => array('Instituicaoestagio.bairro'),
                'conditions' => array('Instituicaoestagio.bairro LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicaoestagio.bairro')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicaoestagio']['bairro'] . "\n";
            }
        }
    }

    public function lista() {

        $parametros = $this->params['named'];
        // pr($parametros);
        $linhas = isset($parametros['linhas']) ? $parametros['linhas'] : null;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'instituicao';
        $pagina = isset($parametros['pagina']) ? $parametros['pagina'] : null;
        $direcao = isset($parametros['direcao']) ? $parametros['direcao'] : null;
        $mudadirecao = isset($parametros['mudadirecao']) ? $parametros['mudadirecao'] : null;
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : null;

        // pr($natureza);
        // die('natureza');

        /* Para ordenar por periodos */
        $this->loadModel('Estagiario');
        $this->Estagiario->recursive = -1;
        $todosperiodos = $this->Estagiario->find('all', [
            'fields' => ['DISTINCT Estagiario.periodo']
                ]
        );
        // pr($todosperiodos);
        // die();
        foreach ($todosperiodos as $c_periodo) {
            $periodos[$c_periodo['Estagiario']['periodo']] = $c_periodo['Estagiario']['periodo'];
        }
        // pr($periodos);
        // die('periodos');

        if ($periodo == null):
            $periodoatual = end($todosperiodos);
            $periodo = $periodoatual['Estagiario']['periodo'];
        endif;

        // Matriz com os dados para ordenar e paginar //
        if ($natureza):
            // pr($natureza);
            // die('natureza');
            if ($natureza == 'null'):
                $natureza = '';
            endif;
            $this->Instituicaoestagio->recursive = 1;
            $g_instituicoes = $this->Instituicaoestagio->find('all', [
                'conditions' => ['Instituicaoestagio.natureza' => $natureza],
                'order' => 'Instituicaoestagio.instituicao'
            ]);
        // $log = $this->Instituicaoestagio->getDataSource()->getLog(false, false);
        // debug($log);
        // die();
        else:
            // die('sem natureza');
            $g_instituicoes = $this->Instituicaoestagio->find('all', [
                ['order' => 'Instituicaoestagio.instituicao']
            ]);
        endif;
        // $log = $this->Instituicaoestagio->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($g_instituicoes);
        // die('g_instituicoes');

        $i = 0;
        foreach ($g_instituicoes as $c_instituicao):
            // pr($c_instituicao['Instituicaoestagio']['natureza']);
            // pr($c_instituicao['Instituicaoestagio']['id']);
            // die('c_instituicao');
            $ultimoperiodo = null;
            $z = 0;
            $instituicao_periodo = null;
            foreach ($c_instituicao['Estagiario'] as $c_periodo):
                $instituicao_periodo[$z] = $c_periodo['periodo'];
                // pr($c_periodo['periodo']);
                $z++;
            endforeach;
            // pr($instituicao_periodo);
            if ($instituicao_periodo) {
                $ultimoperiodo = max($instituicao_periodo);
                // pr($ultimoperiodo);
            }
            // pr($c_instituicao['Visita']);
            // die('c_instituicao');
            $visitas = sizeof($c_instituicao['Visita']);
            if ($visitas > 0):
                $ultimavisita_id = $c_instituicao['Visita'][array_key_last($c_instituicao['Visita'])]['id'];
                $ultimavisita_data = $c_instituicao['Visita'][array_key_last($c_instituicao['Visita'])]['data'];
            elseif (sizeof($c_instituicao['Visita']) == 0):
                $ultimavisita_id = null;
                $ultimavisita_data = null;
            endif;
            // pr($ultimavisita_id);
            // die('ultimavisita_data');
            $estagiarios = sizeof($c_instituicao['Estagiario']);
            $supervisores = sizeof($c_instituicao['Supervisor']);

            $m_instituicao[$i]['instituicao_id'] = isset($c_instituicao['Instituicaoestagio']['id']) ? $c_instituicao['Instituicaoestagio']['id'] : null;
            $m_instituicao[$i]['instituicao'] = isset($c_instituicao['Instituicaoestagio']['instituicao']) ? $c_instituicao['Instituicaoestagio']['instituicao'] : null;
            $m_instituicao[$i]['expira'] = isset($c_instituicao['Instituicaoestagio']['expira']) ? $c_instituicao['Instituicaoestagio']['expira'] : null;
            $m_instituicao[$i]['visita_id'] = isset($ultimavisita_id) ? $ultimavisita_id : null;
            $m_instituicao[$i]['visita'] = isset($ultimavisita_data) ? $ultimavisita_data : null;
            $m_instituicao[$i]['ultimoperiodo'] = isset($ultimoperiodo) ? $ultimoperiodo : null;
            $m_instituicao[$i]['estagiarios'] = isset($estagiarios) ? $estagiarios : null;
            $m_instituicao[$i]['supervisores'] = isset($supervisores) ? $supervisores : null;
            $m_instituicao[$i]['area'] = isset($c_instituicao['Areainstituicao']['area']) ? $c_instituicao['Areainstituicao']['area'] : null;
            $m_instituicao[$i]['natureza'] = isset($c_instituicao['Instituicaoestagio']['natureza']) ? $c_instituicao['Instituicaoestagio']['natureza'] : null;

            $i++;
        endforeach;

        $criterio = array_column($m_instituicao, $ordem);
        // Ordeno o array por diferentes criterios ou chaves
        // pr($ordem);
        // pr($criterio);
        // pr($m_instituicao);
        // die('criterio');
        if ($mudadirecao) {
            $direcao = $mudadirecao;
            // pr('2 ' . $direcao);
            if ($direcao == 'ascendente'):
                $direcao = 'descendente';
                array_multisort($criterio, SORT_DESC, $m_instituicao);
            elseif ($direcao == 'descendente'):
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            endif;
        } else {
            if ($direcao == 'ascendente'):
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            elseif ($direcao == 'descendente'):
                array_multisort($criterio, SORT_DESC, $m_instituicao);
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            endif;
            // die();
        }
        // pr('Direcao: ' . $direcao);
        /* Paginação */
        if ($pagina) {
            $this->Session->write('pagina', $pagina);
        } else {
            $pagina = $this->Session->read('pagina');
            if (!$pagina) {
                $pagina = 1;
            }
        }

        /* Linhas por página */
        if ($linhas == null) {
            $linhas = $this->Session->read('linhas');
            if (!$linhas) {
                $linhas = 15;
                $this->Session->write('linhas', $linhas);
            }
        }
        // pr($linhas);
        // die();
        if ($linhas == 0) { // Sem paginação
            $q_paginas = 1;
        } else {
            $registros = sizeof($m_instituicao);
            // echo "Calculo quantos registros: " . $registros . "<br>";
            $q_paginas = $registros / $linhas;
            // echo "Quantas páginas " . ceil($q_paginas) . "<br>";
            // die();
            $c_pagina[] = null;
            $pagina_inicial = 0;
            $pagina_final = 0;
            for ($i = 0; $i < ceil($q_paginas); $i++):
                $pagina_inicial = $pagina_inicial + $pagina_final;
                $pagina_final = $linhas;
                $c_pagina[] = array_slice($m_instituicao, $pagina_inicial, $pagina_final);
            endfor;
        }
        // die();
        // $this->set('periodoatual', reset($periodos));
        // $this->set('periodos', $periodos);
        $this->set('linhas', $linhas);
        $this->set('direcao', $direcao);
        $this->set('ordem', $ordem);
        $this->set('pagina', $pagina);
        // echo $linhas . " " .  $pagina . '<br>';
        if ($linhas == 0) {
            $this->set('instituicoes', $m_instituicao);
        } else {
            $this->set('q_paginas', ceil($q_paginas));
            $this->set('paginas', $c_pagina);
            $this->set('instituicoes', $c_pagina[$pagina]);
        }
        // die();
    }

    public function index1() {

        $parametros = $this->params['named'];
        // pr($parametros);
        $linhas = isset($parametros['linhas']) ? $parametros['linhas'] : null;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'instituicao';
        $pagina = isset($parametros['pagina']) ? $parametros['pagina'] : null;
        $direcao = isset($parametros['direcao']) ? $parametros['direcao'] : null;
        $mudadirecao = isset($parametros['mudadirecao']) ? $parametros['mudadirecao'] : null;
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : null;

        // pr($natureza);
        // die('natureza');

        /* Para ordenar por periodos */
        $this->loadModel('Estagiario');
        $this->Estagiario->recursive = -1;
        $todosperiodos = $this->Estagiario->find('all', [
            'fields' => ['DISTINCT Estagiario.periodo']
                ]
        );
        // pr($todosperiodos);
        // die();
        foreach ($todosperiodos as $c_periodo) {
            $periodos[$c_periodo['Estagiario']['periodo']] = $c_periodo['Estagiario']['periodo'];
        }
        // pr($periodos);
        // die('periodos');

        if ($periodo == null):
            $periodoatual = end($todosperiodos);
            $periodo = $periodoatual['Estagiario']['periodo'];
        endif;

        // Matriz com os dados para ordenar e paginar //
        if ($natureza):
            // pr($natureza);
            // die('natureza');
            if ($natureza == 'null'):
                $natureza = '';
            endif;
            $this->Instituicaoestagio->recursive = 1;
            $g_instituicoes = $this->Instituicaoestagio->find('all', [
                'conditions' => ['Instituicaoestagio.natureza' => $natureza],
                'order' => 'Instituicaoestagio.instituicao'
            ]);
        // $log = $this->Instituicao->getDataSource()->getLog(false, false);
        // debug($log);
        // die();
        else:
            // die('sem natureza');
            $g_instituicoes = $this->Instituicaoestagio->find('all', [
                ['order' => 'Instituicaoestagio.instituicao']
            ]);
        endif;
        // $log = $this->Instituicaoestagio->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($g_instituicoes);
        // die('g_instituicoes');

        $i = 0;
        foreach ($g_instituicoes as $c_instituicao):
            // pr($c_instituicao['Instituicaoestagio']['natureza']);
            // pr($c_instituicao['Instituicaoestagio']['id']);
            // die('c_instituicao');
            $ultimoperiodo = null;
            $z = 0;
            $instituicao_periodo = null;
            foreach ($c_instituicao['Estagiario'] as $c_periodo):
                $instituicao_periodo[$z] = $c_periodo['periodo'];
                // pr($c_periodo['periodo']);
                $z++;
            endforeach;
            // pr($instituicao_periodo);
            if ($instituicao_periodo) {
                $ultimoperiodo = max($instituicao_periodo);
                // pr($ultimoperiodo);
            }
            // pr($c_instituicao['Visita']);
            // die('c_instituicao');
            $visitas = sizeof($c_instituicao['Visita']);
            if ($visitas > 0):
                $ultimavisita_id = $c_instituicao['Visita'][array_key_last($c_instituicao['Visita'])]['id'];
                $ultimavisita_data = $c_instituicao['Visita'][array_key_last($c_instituicao['Visita'])]['data'];
            elseif (sizeof($c_instituicao['Visita']) == 0):
                $ultimavisita_id = null;
                $ultimavisita_data = null;
            endif;
            // pr($ultimavisita_id);
            // die('ultimavisita_data');
            $estagiarios = sizeof($c_instituicao['Estagiario']);
            $supervisores = sizeof($c_instituicao['Supervisor']);

            $m_instituicao[$i]['instituicao_id'] = $c_instituicao['Instituicaoestagio']['id'];
            $m_instituicao[$i]['instituicao'] = $c_instituicao['Instituicaoestagio']['instituicao'];
            $m_instituicao[$i]['cnpj'] = $c_instituicao['Instituicaoestagio']['cnpj'];
            $m_instituicao[$i]['email'] = $c_instituicao['Instituicaoestagio']['email'];
            $m_instituicao[$i]['url'] = $c_instituicao['Instituicaoestagio']['url'];
            $m_instituicao[$i]['telefone'] = $c_instituicao['Instituicaoestagio']['telefone'];
            $m_instituicao[$i]['beneficio'] = $c_instituicao['Instituicaoestagio']['beneficio'];
            $m_instituicao[$i]['avaliacao'] = $c_instituicao['Instituicaoestagio']['avaliacao'];

            $i++;
        endforeach;

        $criterio = array_column($m_instituicao, $ordem);
        // Ordeno o array por diferentes criterios ou chaves
        // pr($ordem);
        // pr('muda ' . $mudadirecao);
        // pr('1 ' . $direcao);
        if ($mudadirecao) {
            $direcao = $mudadirecao;
            // pr('2 ' . $direcao);
            if ($direcao == 'ascendente'):
                $direcao = 'descendente';
                array_multisort($criterio, SORT_DESC, $m_instituicao);
            elseif ($direcao == 'descendente'):
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            endif;
        } else {
            if ($direcao == 'ascendente'):
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            elseif ($direcao == 'descendente'):
                array_multisort($criterio, SORT_DESC, $m_instituicao);
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            endif;
            // die();
        }
        // pr('Direcao: ' . $direcao);
        /* Paginação */
        if ($pagina) {
            $this->Session->write('pagina', $pagina);
        } else {
            $pagina = $this->Session->read('pagina');
            if (!$pagina) {
                $pagina = 1;
            }
        }

        /* Linhas por página */
        if ($linhas == null) {
            $linhas = $this->Session->read('linhas');
            if (!$linhas) {
                $linhas = 15;
                $this->Session->write('linhas', $linhas);
            }
        }
        // pr($linhas);
        // die();
        if ($linhas == 0) { // Sem paginação
            $q_paginas = 1;
        } else {
            $registros = sizeof($m_instituicao);
            // echo "Calculo quantos registros: " . $registros . "<br>";
            $q_paginas = $registros / $linhas;
            // echo "Quantas páginas " . ceil($q_paginas) . "<br>";
            // die();
            $c_pagina[] = null;
            $pagina_inicial = 0;
            $pagina_final = 0;
            for ($i = 0; $i < ceil($q_paginas); $i++):
                $pagina_inicial = $pagina_inicial + $pagina_final;
                $pagina_final = $linhas;
                $c_pagina[] = array_slice($m_instituicao, $pagina_inicial, $pagina_final);
            endfor;
        }
        // die();
        // $this->set('periodoatual', reset($periodos));
        // $this->set('periodos', $periodos);
        $this->set('linhas', $linhas);
        $this->set('direcao', $direcao);
        $this->set('ordem', $ordem);
        $this->set('pagina', $pagina);
        // echo $linhas . " " .  $pagina . '<br>';
        if ($linhas == 0) {
            $this->set('instituicoes', $m_instituicao);
        } else {
            $this->set('q_paginas', ceil($q_paginas));
            $this->set('paginas', $c_pagina);
            $this->set('instituicoes', $c_pagina[$pagina]);
        }
        // die();
    }

    public function todososperiodos($id = null) {

        $todososperiodos = $this->Instituicaoestagio->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));
        asort($todososperiodos);
        return $todososperiodos;
    }

}
