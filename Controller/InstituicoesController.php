<?php

class InstituicoesController extends AppController {

    public $name = "Instituicoes";
    public $components = array('Auth');
    public $paginate = [
        'limit' => 25,
        'order' => ['Instituicao.instituicao']
    ];

    public function beforeFilter() {
        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'lista', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/Userestagios/login/');
        }
    }

    public function index() {

        $parametros = $this->params['named'];
        // print_r($parametros);
        $areainstituicao_id = isset($parametros['areainstituicoes_id']) ? $parametros['areainstituicoes_id'] : null;
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : null;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;
        $limite = isset($parametros['limite']) ? $parametros['limite'] : 10;

        // pr($periodo);

        $todosPeriodos = $this->Instituicao->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));

        if ($periodo) {

            if ($areainstituicao_id) {
                $conditions = ['Instituicao.areainstituicoes_id' => $areainstituicao_id, 'Estagiario.periodo' => $periodo];
            } elseif ($natureza) {
                $conditions = ['Instituicao.natureza' => $natureza, 'Estagiario.periodo' => $periodo];
            } else {
                $conditions = ['Estagiario.periodo' => $periodo];
            }
        } else {

            if ($areainstituicao_id) {
                $conditions = ['Instituicao.areainstituicoes_id' => $areainstituicao_id];
            } elseif ($natureza) {
                $conditions = ['Instituicao.natureza' => $natureza];
            } else {
                $conditions = null;
            }
        }
        // pr($conditions);
        // die('conditions');

        if (empty($conditions)) {
            $this->Paginator->settings = ['Instituicao' =>
                ['order' => 'Instituicao.instituicao'],
                ['contain' => 'Estagiario']
            ];
        }

        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        $this->set('limite', $limite);
        $this->set('instituicoes', $this->Paginate('Instituicao'));
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
            'fields' => ['instituicao_id', 'periodo'],
            'conditions' => ['Estagiario.periodo' => $periodo],
            'group' => 'instituicao_id'
        ]);

        $i = 0;
        foreach ($instituicoes as $c_instituicao) {
            // pr($c_instituicao);
            $instituicao = $this->Instituicao->find('first', [
                'fields' => ['instituicao', 'expira', 'area', 'natureza'],
                'conditions' => ['Instituicao.id' => $c_instituicao['Estagiario']['instituicao_id']]
            ]);
            // pr($instituicao);
            $resultado[$i]['instituicao_id'] = $instituicao['Instituicao']['id'];
            $resultado[$i]['instituicao'] = $instituicao['Instituicao']['instituicao'];
            $resultado[$i]['expira'] = $instituicao['Instituicao']['expira'];
            $resultado[$i]['areainstituicao'] = $instituicao['Instituicao']['area'];
            $resultado[$i]['natureza'] = $instituicao['Instituicao']['natureza'];

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
        $area_instituicao = $this->Instituicao->Areainstituicao->find('list', array(
            'order' => 'Areainstituicao.area'));
        // pr($area_instituicao);
        // die();
        $this->set('id_area_instituicao', $area_instituicao);

        if ($this->data) {
            if ($this->Instituicao->save($this->data)) {
                $this->Session->setFlash(__('Dados da instituição inseridos!'));
                $this->redirect('/Instituicoes/view/' . $this->Instituicao->Id);
            }
        }
    }

    public function view($id = null) {

        $this->Instituicao->contain('Visita', 'Areainstituicao', 'Supervisor', 'Estagiario');
        $instituicao = $this->Instituicao->find('first', [
            'conditions' => ['Instituicao.id' => $id],
            'order' => 'Instituicao.instituicao']);
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
            array_multisort(array_column($estudanteestagiario ,'nome'), $estudanteestagiario);
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

        $this->Instituicao->recursive = -1;
        $proximo = $this->Instituicao->find('neighbors', [
            'field' => 'instituicao', 'value' => $instituicao['Instituicao']['instituicao']
        ]);
        // pr($proximo);
        if ($proximo['next']) {
            $this->set('registro_next', $proximo['next']['Instituicao']['id']);
        } else {
            $this->set('registro_prev', $proximo['prev']['Instituicao']['id']);
        }
        if ($proximo['prev']) {
            $this->set('registro_prev', $proximo['prev']['Instituicao']['id']);
        } else {
            $this->set('registro_prev', $proximo['next']['Instituicao']['id']);
        }
        $this->set('instituicao', $instituicao);
    }

    public function edit($id = null) {

        $this->Instituicao->id = $id;

        $area_instituicao = $this->Instituicao->Areainstituicao->find('list', array(
            'order' => 'Areainstituicao.area'
        ));

        $this->set('area_instituicao', $area_instituicao);

        if (empty($this->data)) {
            $this->data = $this->Instituicao->read();
        } else {
            if ($this->Instituicao->save($this->data)) {
                // print_r($id);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Instituicoes/view/' . $id);
            }
        }
    }

    public function delete($id = null) {
        $instituicao = $this->Instituicao->find('first', array(
            'conditions' => array('Instituicao.id' => $id)
        ));

        $murais = $instituicao['Mural'];
        $supervisores = $instituicao['Supervisor'];
        $alunos = $instituicao['Estagiario'];

        if ($murais) {
            // die(pr($murais[0]['id']));

            $this->Session->setFlash(__('Há murais vinculados com esta instituição'));
            $this->redirect('/Muralestagios/view/' . $murais[0]['id']);
        } elseif ($supervisores) {
            $this->Session->setFlash(__('Há supervisores vinculados com esta instituição'));
            $this->redirect('/Instituicoes/view/' . $id);
        } elseif ($alunos) {
            $this->Session->setFlash(__('Há alunos estagiários vinculados com esta instituição'));
            $this->redirect('/Instituicoes/view/' . $id);
        } else {
            $this->Instituicao->delete($id);
            $this->Session->setFlash(__('Registro excluído'));
            $this->redirect('/Instituicoes/index/');
        }
    }

    public function deleteassociacao($id = null) {
        $id_superinstituicao = $this->Instituicao->InstituicaoSupervisor->find('first', array('conditions' => 'InstituicaoSupervisor.id = ' . $id));
        // pr($id_superinstituicao);
        // die();

        $this->Instituicao->InstituicaoSupervisor->delete($id);

        $this->Session->setFlash(__("Supervisor excluido da instituição"));
        $this->redirect('/Instituicoes/view/' . $id_superinstituicao['InstituicaoSupervisor']['instituicao_id']);
    }

    public function addassociacao() {
        if ($this->data) {
            // pr($this->request->data);
            // die();
            if ($this->Instituicao->InstituicaoSupervisor->save($this->data)) {
                $this->Session->setFlash(__('Dados inseridos'));
                $this->redirect('/Instituicoes/view/' . $this->data['InstituicaoSupervisor']['instituicao_id']);
            }
        }
    }

    public function busca($id = null) {
        if ($id) {
            $this->request->data['Instituicao']['instituicao'] = $id;
        }

        if (isset($this->request->data['Instituicao']['instituicao'])):
            if ($this->request->data['Instituicao']['instituicao']) {
                $condicao = array('Instituicao.instituicao like' => '%' . $this->data['Instituicao']['instituicao'] . '%');
                $instituicoes = $this->Instituicao->find('all', array('conditions' => $condicao, 'order' => 'Instituicao.instituicao'));

                // Nenhum resultado
                if (empty($instituicoes)) {
                    $this->Session->setFlash(__("Não foram encontrados registros"));
                } else {
                    $this->set('instituicoes', $instituicoes);
                    $this->set('busca', $this->data['Instituicao']['instituicao']);
                }
            }
        endif;
    }

    /*
     * Seleciona supervisor em funcao da selecao da instituicao de estagio
     */

    public function seleciona_supervisor($id = null) {

        $instituicao_id = $this->request->data['Inscricao']['instituicao_id'];
        // pr($instituicao_id);
        // die('instituicao_id');
        if ($instituicao_id != 0) {
            $supervisoresinstituicao = $this->Instituicao->query('SELECT Supervisor.id, Supervisor.nome FROM estagio AS Instituicao '
                    . 'LEFT JOIN instituicao_supervisor AS InstituicaoSupervisor ON Instituicao.id = InstituicaoSupervisor.instituicao_id '
                    . 'LEFT JOIN supervisores AS Supervisor ON InstituicaoSupervisor.supervisor_id = Supervisor.id '
                    . 'WHERE Instituicao.id = ' . $instituicao_id);
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
        $this->Instituicao->recursive = -1;
        $natureza = $this->Instituicao->find('all', [
            'fields' => ['Instituicao.natureza', "count('Instituicao.natureza') as qnatureza"],
            'order' => ['Instituicao.natureza'],
            'group' => 'Instituicao.natureza'
                ]
        );
        // die();
        $this->set('natureza', $natureza);
    }

    public function listainstituicao() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->Instituicao->recursive = -1;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.instituicao'),
                'conditions' => array('Instituicao.instituicao LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.instituicao')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['instituicao'] . "\n";
            }
        }
    }

    public function listanatureza() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->Instituicao->recursive = -1;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.natureza'),
                'conditions' => array('Instituicao.natureza LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.natureza')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['natureza'] . "\n";
            }
        }
    }

    public function listabairro() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->Instituicao->recursive = -1;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.bairro'),
                'conditions' => array('Instituicao.bairro LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.bairro')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['bairro'] . "\n";
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
            $this->Instituicao->recursive = 1;
            $g_instituicoes = $this->Instituicao->find('all', [
                'conditions' => ['Instituicao.natureza' => $natureza],
                'order' => 'Instituicao.instituicao'
            ]);
        // $log = $this->Instituicao->getDataSource()->getLog(false, false);
        // debug($log);
        // die();
        else:
            // die('sem natureza');
            $g_instituicoes = $this->Instituicao->find('all', [
                ['order' => 'Instituicao.instituicao']
            ]);
        endif;
        // $log = $this->Instituicao->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($g_instituicoes);
        // die('g_instituicoes');

        $i = 0;
        foreach ($g_instituicoes as $c_instituicao):
            // pr($c_instituicao['Instituicao']['natureza']);
            // pr($c_instituicao['Instituicao']['id']);
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

            $m_instituicao[$i]['instituicao_id'] = isset($c_instituicao['Instituicao']['id']) ? $c_instituicao['Instituicao']['id'] : null;
            $m_instituicao[$i]['instituicao'] = isset($c_instituicao['Instituicao']['instituicao']) ? $c_instituicao['Instituicao']['instituicao'] : null;
            $m_instituicao[$i]['expira'] = isset($c_instituicao['Instituicao']['expira']) ? $c_instituicao['Instituicao']['expira'] : null;
            $m_instituicao[$i]['visita_id'] = isset($ultimavisita_id) ? $ultimavisita_id : null;
            $m_instituicao[$i]['visita'] = isset($ultimavisita_data) ? $ultimavisita_data : null;
            $m_instituicao[$i]['ultimoperiodo'] = isset($ultimoperiodo) ? $ultimoperiodo : null;
            $m_instituicao[$i]['estagiarios'] = isset($estagiarios) ? $estagiarios : null;
            $m_instituicao[$i]['supervisores'] = isset($supervisores) ? $supervisores : null;
            $m_instituicao[$i]['area'] = isset($c_instituicao['Areainstituicao']['area']) ? $c_instituicao['Areainstituicao']['area'] : null;
            $m_instituicao[$i]['natureza'] = isset($c_instituicao['Instituicao']['natureza']) ? $c_instituicao['Instituicao']['natureza'] : null;

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
            $this->Instituicao->recursive = 1;
            $g_instituicoes = $this->Instituicao->find('all', [
                'conditions' => ['Instituicao.natureza' => $natureza],
                'order' => 'Instituicao.instituicao'
            ]);
        // $log = $this->Instituicao->getDataSource()->getLog(false, false);
        // debug($log);
        // die();
        else:
            // die('sem natureza');
            $g_instituicoes = $this->Instituicao->find('all', [
                ['order' => 'Instituicao.instituicao']
            ]);
        endif;
        // $log = $this->Instituicao->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($g_instituicoes);
        // die('g_instituicoes');

        $i = 0;
        foreach ($g_instituicoes as $c_instituicao):
            // pr($c_instituicao['Instituicao']['natureza']);
            // pr($c_instituicao['Instituicao']['id']);
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

            $m_instituicao[$i]['instituicao_id'] = $c_instituicao['Instituicao']['id'];
            $m_instituicao[$i]['instituicao'] = $c_instituicao['Instituicao']['instituicao'];
            $m_instituicao[$i]['cnpj'] = $c_instituicao['Instituicao']['cnpj'];
            $m_instituicao[$i]['email'] = $c_instituicao['Instituicao']['email'];
            $m_instituicao[$i]['url'] = $c_instituicao['Instituicao']['url'];
            $m_instituicao[$i]['telefone'] = $c_instituicao['Instituicao']['telefone'];
            $m_instituicao[$i]['beneficio'] = $c_instituicao['Instituicao']['beneficio'];
            $m_instituicao[$i]['avaliacao'] = $c_instituicao['Instituicao']['avaliacao'];

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

        $todososperiodos = $this->Instituicao->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));
        asort($todososperiodos);
        return $todososperiodos;
    }

}
