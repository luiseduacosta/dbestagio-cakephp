<?php

class InstituicaosController extends AppController {

    public $name = "Instituicaos";
    public $components = array('Auth');

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'busca');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/users/login/');
        }
    }

    public function index() {

        $parametros = $this->params['named'];
        // print_r($parametros);
        $area_instituicao_id = isset($parametros['area_instituicoes_id']) ? $parametros['area_instituicoes_id'] : NULL;
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : NULL;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $limite = isset($parametros['limite']) ? $parametros['limite'] : 10;

        $todosPeriodos = $this->Instituicao->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));

        // if (!$periodo) $periodo = end($todosPeriodos);

        $this->Instituicao->virtualFields['virtualMaxPeriodo'] = 'max(Estagiario.periodo)';
        $this->Instituicao->virtualFields['virtualEstudantes'] = 'count(Distinct Estagiario.registro)';
        $this->Instituicao->virtualFields['virtualSupervisores'] = 'count(Distinct Estagiario.id_supervisor)';

        // pr($periodo);
        // die();

        if ($periodo):
            if ($area_instituicao_id):
                $this->paginate = array(
                    'limit' => $limite,
                    'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'AreaInstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('area_instituicoes_id' => $area_instituicao_id, 'periodo' => $periodo),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            elseif ($natureza):
                $this->paginate = array(
                    'limit' => $limite,
                    'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'AreaInstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('natureza' => $natureza, 'periodo' => $periodo),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            else:
                $this->paginate = array(
                    'limit' => $limite,
                    'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'AreaInstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'conditions' => array('periodo' => $periodo),
                    'group' => array('Estagiario.id_instituicao'),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            endif;
        else:
            if ($area_instituicao_id):
                $this->paginate = array(
                    'limit' => $limite,
                    'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'AreaInstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('area_instituicoes_id' => $area_instituicao_id),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            elseif ($natureza):
                $this->paginate = array(
                    'limit' => $limite,
                    'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'AreaInstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('natureza' => $natureza),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            else:
                $this->paginate = array(
                    'limit' => $limite,
                    'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'AreaInstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            endif;
        endif;

        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        $this->set('limite', $limite);
        $this->set('instituicoes', $this->Paginate('Instituicao'));
    }

    public function add() {

        $area_instituicao = $this->Instituicao->AreaInstituicao->find('list', array(
            'order' => 'AreaInstituicao.area'));
        // pr($area_instituicao);
        // die();
        $this->set('id_area_instituicao', $area_instituicao);

        if ($this->data) {
            if ($this->Instituicao->save($this->data)) {
                $this->Session->setFlash('Dados da instituição inseridos!');
                $this->Instituicao->getLastInsertId();
                $this->redirect('/Instituicaos/view/' . $this->Instituicao->getLastInsertId());
            }
        }
    }

    public function view($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
            'conditions' => array('Instituicao.id' => $id),
            'order' => 'Instituicao.instituicao'));
        // pr($instituicao);

        /* Para acrescentar um supervisor */
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', array(
            'order' => array('Supervisor.nome')));

        $this->set('supervisores', $supervisores);

        $proximo = $this->Instituicao->find('neighbors', array(
            'field' => 'instituicao', 'value' => $instituicao['Instituicao']['instituicao']));

        $this->set('registro_next', $proximo['next']['Instituicao']['id']);
        $this->set('registro_prev', $proximo['prev']['Instituicao']['id']);

        $this->set('instituicao', $instituicao);
    }

    public function edit($id = NULL) {

        $this->Instituicao->id = $id;

        $area_instituicao = $this->Instituicao->AreaInstituicao->find('list', array(
            'order' => 'AreaInstituicao.area'
        ));

        $this->set('area_instituicao', $area_instituicao);

        if (empty($this->data)) {
            $this->data = $this->Instituicao->read();
        } else {
            if ($this->Instituicao->save($this->data)) {
                // print_r($id);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Instituicaos/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
            'conditions' => array('Instituicao.id' => $id)
        ));

        $murais = $instituicao['Mural'];
        $supervisores = $instituicao['Supervisor'];
        $alunos = $instituicao['Estagiario'];

        if ($murais) {
            // die(pr($murais[0]['id']));

            $this->Session->setFlash('Há murais vinculados com esta instituição');
            $this->redirect('/Murals/view/' . $murais[0]['id']);
        } elseif ($supervisores) {

            $this->Session->setFlash('Há supervisores vinculados com esta instituição');
            $this->redirect('/Instituicaos/view/' . $id);
        } elseif ($alunos) {

            $this->Session->setFlash('Há alunos estagiários vinculados com esta instituição');
            $this->redirect('/Instituicaos/view/' . $id);
        } else {
            $this->Instituicao->delete($id);
            $this->Session->setFlash('Registro excluído');
            $this->redirect('/Instituicaos/index/');
        }
    }

    public function deleteassociacao($id = NULL) {

        $id_superinstituicao = $this->Instituicao->InstSuper->find('first', array('conditions' => 'InstSuper.id = ' . $id));
        // pr($id_superinstituicao);
        // die();

        $this->Instituicao->InstSuper->delete($id);

        $this->Session->setFlash("Supervisor excluido da instituição");
        $this->redirect('/Instituicaos/view/' . $id_superinstituicao['InstSuper']['id_instituicao']);
    }

    public function addassociacao() {

        if ($this->data) {
            pr($this->data);
            die();
            if ($this->Instituicao->InstSuper->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/Instituicaos/view/' . $this->data['InstSuper']['id_instituicao']);
            }
        }
    }

    public function busca($id = NULL) {

        if ($id) {
            $this->request->data['Instituicao']['instituicao'] = $id;
        }
        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Instituicao.instituicao' => 'asc')
        );

        if ($this->request->data['Instituicao']['instituicao']) {

            $condicao = array('Instituicao.instituicao like' => '%' . $this->data['Instituicao']['instituicao'] . '%');
            $instituicoes = $this->Instituicao->find('all', array('conditions' => $condicao));

            // Nenhum resultado
            if (empty($instituicoes)) {
                $this->Session->setFlash("Não foram encontrados registros");
            } else {
                $this->set('instituicoes', $this->Paginate($condicao));
                $this->set('busca', $this->data['Instituicao']['instituicao']);
            }
        }
    }

    /*
     * Seleciona supervisor em funcao da selecao da instituicao
     */

    public function seleciona_supervisor($id = NULL) {

        // Configure::write('debug', 2);
        if ($id != 0) {
            $supervisores = $this->Instituicao->find('all', array(
                'conditions' => array('Instituicao.id = ' . $id)
                    )
            );

            if ($supervisores) {
                $i = 0;
                foreach ($supervisores as $c_supervisor) {
                    // pr($c_supervisor['Supervisor']);
                    foreach ($c_supervisor['Supervisor'] as $cada_supervisor) {
                        $super[$i]['nome'] = $cada_supervisor['nome'];
                        $super[$i]['id'] = $cada_supervisor['id'];
                        $i++;
                    }
                    // die();
                }

                // Pode ser que nao tenha supervisores
                if (isset($super)) {
                    asort($super);
                    $this->set('supervisores', $super);
                }
                // pr($super);
                $this->set('id', $id);
            } else {
                $this->Sesion->setFlash("Sem supervisores cadastrados");
            }

            /*
             * Poderia tambem capturar o professor e a area da instituicao
             * Para isto consulto a tabela estagiarios
             * A area e o professor poderiam ser passados atraves de um cooke
             */
            $this->loadModel('Estagiario');
            $prof_area = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.id_instituicao =' . $id),
                'fields' => array('Estagiario.id_supervisor', 'Estagiario.id_professor', 'Estagiario.id_area', 'Estagiario.periodo'),
                'order' => array('Estagiario.periodo DESC')
            ));
            // pr($prof_area);

            $id_area = $prof_area['Estagiario']['id_area'];
            $id_prof = $prof_area['Estagiario']['id_professor'];

            // $id_area = $this->Estagiario->find('all');
            $this->Session->delete('id_area', $id_area);
            $this->Session->delete('id_prof', $id_prof);
            $this->Session->write('id_area', $id_area);
            $this->Session->write('id_prof', $id_prof);
        } else {

            $this->Sesion->setFlash("Selecione uma instituição");
            $this->redirect('/Inscricaos/termocompromisso/' . $id);
        }
    }

    public function natureza() {

        $this->Instituicao->virtualFields['qnatureza'] = 'count(natureza)';

        $natureza = $this->Instituicao->find('all', array(
            'fields' => array('Instituicao.natureza', 'count(Instituicao.natureza) as Instituicao__qnatureza')
                /* 'group' => array('Instituicao.natureza') */
                )
        );

        $this->set('natureza', $natureza);
    }

    public function listainstituicao() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
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
        $linhas = isset($parametros['linhas']) ? $parametros['linhas'] : NULL;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'instituicao';
        $pagina = isset($parametros['pagina']) ? $parametros['pagina'] : NULL;
        $direcao = isset($parametros['direcao']) ? $parametros['direcao'] : NULL;
        $mudadirecao = isset($parametros['mudadirecao']) ? $parametros['mudadirecao'] : NULL;

        // Para ordenar por periodos //
        // Nao implementado //
        $todosperiodos = $this->Instituicao->Estagiario->find('all', array(
            'fields' => array('DISTINCT Estagiario.periodo'),
                )
        );
        foreach ($todosperiodos as $c_periodo) {
            $periodos[$c_periodo['Estagiario']['periodo']] = $c_periodo['Estagiario']['periodo'];
        }

        if ($periodo == NULL):
            $periodoatual = end($todosperiodos);
            $periodo = $periodoatual['Estagiario']['periodo'];
        endif;

        // Matriz com os dados para ordenar e paginar //
        $g_instituicoes = $this->Instituicao->find('all', array(
            'order' => 'Instituicao.instituicao'
                )
        );
        // pr($g_instituicoes);
        $i = 0;
        foreach ($g_instituicoes as $c_instituicao):
            // pr($c_instituicao['Mural']);
            $ultimoperiodo = NULL;
            $q_estagiarios = sizeof($c_instituicao['Estagiario']);
            // echo $q_estagiarios . "<br>";
            if ($q_estagiarios > 0):
                $p = 0;
                foreach ($c_instituicao['Estagiario'] as $c_periodo):
                    $instituicao_periodo[$p] = $c_periodo['periodo'];
                    $p++;
                endforeach;
                $ultimoperiodo = max($instituicao_periodo);
            else:
                $ultimoperiodo = NULL;
            endif;

            $visitas = sizeof($c_instituicao['Visita']);
            if ($visitas > 0):
                $ultimavisita = max($c_instituicao['Visita']);
            elseif (sizeof($c_instituicao['Visita']) == 0):
                $ultimavisita = NULL;
            endif;
            // pr($ultimavisita);

            $estagiarios = sizeof($c_instituicao['Estagiario']);
            $supervisores = sizeof($c_instituicao['Supervisor']);

            $m_instituicao[$i]['instituicao_id'] = $c_instituicao['Instituicao']['id'];
            $m_instituicao[$i]['instituicao'] = $c_instituicao['Instituicao']['instituicao'];
            $m_instituicao[$i]['expira'] = $c_instituicao['Instituicao']['expira'];
            $m_instituicao[$i]['visita_id'] = $ultimavisita['id'];
            $m_instituicao[$i]['visita'] = $ultimavisita['data'];
            $m_instituicao[$i]['ultimoperiodo'] = $ultimoperiodo;
            $m_instituicao[$i]['estagiarios'] = $estagiarios;
            $m_instituicao[$i]['supervisores'] = $supervisores;
            $m_instituicao[$i]['area'] = $c_instituicao['AreaInstituicao']['area'];
            $m_instituicao[$i]['natureza'] = $c_instituicao['Instituicao']['natureza'];
            $criterio[] = $m_instituicao[$i][$ordem];

            $i++;
        endforeach;

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
        // Paginação //
        if ($pagina) {
            $this->Session->write('pagina', $pagina);
        } else {
            $pagina = $this->Session->read('pagina');
            if (!$pagina) {
                $pagina = 1;
            }
        }

        if ($linhas == NULL) {
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
            $c_pagina[] = NULL;
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
        if ($linhas == 0) {
            $this->set('instituicoes', $m_instituicao);
        } else {
            $this->set('q_paginas', ceil($q_paginas));
            $this->set('paginas', $c_pagina);
            $this->set('instituicoes', $c_pagina[$pagina]);
        }
        // die();
    }

}

?>
