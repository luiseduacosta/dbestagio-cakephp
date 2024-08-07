<?php

class ProfessoresController extends AppController {

    public $name = "Professores";
    public $components = array('Auth');
    public $paginate = array(
        'limit' => 10,
        'order' => array('Professor.nome' => 'asc'));

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash(__("Administrador"), "flash_notification");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'pauta');
            // $this->Session->setFlash(__("Estudante"), "flash_notification");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add' . 'edit' . 'index', 'view', 'pauta');
            // $this->Session->setFlash(__("Professor"), "flash_notification");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'pauta');
            // $this->Session->setFlash(__("Professor/Supervisor"), "flash_notification");
        } else {
            $this->Session->setFlash(__("Não autorizado"), "flash_notification");
            $this->redirect('/Muralestagios/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->Professor->recursive = -1;
        $this->Paginator->settings = ['Professor' => [
                'order' => ['Professor.nome']
            ]
        ];
        $this->set('professores', $this->paginate('Professor'));
        // die();
    }

    public function view($id = NULL) {

        // Configure::write('debug', 0);
        // Somente o próprio pode ver
        if ($this->Session->read('numero')) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Professor->find('first', [
                'conditions' => ['Professor.siape' => $this->Session->read('numero')]
            ]);
            // pr($verifica);
            // die('verifica');
            if ($verifica) {
                if ($id != $verifica['Professor']['id']) {
                    $this->Session->setFlash(__("Acesso não autorizado"), "flash_notification");
                    $this->redirect("/Professores/index");
                    die("Não autorizado");
                }
            } else {
                $this->Session->setFlash(__("Acesso não autorizado"), "flash_notification");
                $this->redirect("/Professores/index");
                die("Não autorizado");
            }
        }

        $professor = $this->Professor->find('first', array(
            'conditions' => array('Professor.id' => $id),
            'order' => 'Professor.nome'));

        // pr($professor);

        $this->set('professor', $professor);
    }

    public function edit($id = NULL) {

        $this->Professor->id = $id;

        /* Meses em português */
        $this->set('meses', $this->meses());

        // Somente o próprio pode ver
        if ($this->Session->read('numero')) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Professor->findBySiape($this->Session->read('numero'));
            if ($id != $verifica['Professor']['id']) {
                $this->Session->setFlash(__("Acesso não autorizado"), "flash_notification");
                $this->redirect("/Professores/view/" . $id);
                die("Não autorizado");
            }
        }

        if (empty($this->data)) {
            $this->data = $this->Professor->read();
        } else {
            if ($this->Professor->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash(__("Atualizado"), "flash_notification");
                $this->redirect('/Professores/view/' . $id);
            }
        }
    }

    public function add() {

        /* Meses em português */
        $this->set('meses', $this->meses());

        if ($this->data) {
            if ($this->Professor->save($this->data)) {
                $this->Session->setFlash(__('Dados inseridos'), "flash_notification");
                $this->Professor->getLastInsertId();
                $this->redirect('/Professores/view/' . $this->Professor->getLastInsertId());
            }
        }
    }

    public function pauta() {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;

        $todosPeriodo = $this->Professor->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));
        // pr($todosPeriodo);
        // pr($periodo);

        if (!$periodo)
            $periodo = end($todosPeriodo);

        $this->Professor->recursive = 1;
        $estagiarios = $this->Professor->find('all');
        // pr($estagiarios);
        // die('estagiarios');
        $k = 0;
        $pauta = null;
        foreach ($estagiarios as $c_professor) {
            // pr($c_professor);
            // die('c_professor');
            $professor = $c_professor['Professor']['nome'];
            $professor_id = $c_professor['Professor']['id'];
            $departamento = $c_professor['Professor']['departamento'];
            // $area = $c_professor['Professor']['id_area'];

            $k++;
            // echo $professor . " ";
            $i = 0;
            /* Quantos estagiarios teve */
            $estagiariostotal = sizeof($c_professor['Estagiario']);
            // echo '<br>';
            $p = 1;
            foreach ($c_professor['Estagiario'] as $estagiariodoprofessor) {
                // pr($estagiariodoprofessor);
                // pr($periodo);
                // die('estagiariodoprofessor');
                if ($estagiariodoprofessor['periodo'] == $periodo) {

                    // echo "Período: " . $periodo . "<br />";
                    $this->loadModel('Areaestagio');
                    $this->Areaestagio->recursive = -1;
                    $area = $this->Areaestagio->find('first', array('conditions' => array('Areaestagio.id' => $estagiariodoprofessor['areaestagio_id'])));
                    // pr($area);
                    // echo $k . " " . $professor . " -> " . " " . $periodo . " " . $p++ . "<br>";
                    // die('area');
                    $pauta[$k]['id'] = $k;
                    $pauta[$k]['professor'] = $professor;
                    $pauta[$k]['docente_id'] = $professor_id;
                    $pauta[$k]['departamento'] = $departamento;
                    $pauta[$k]['estagariariostotal'] = $estagiariostotal;
                    if ($area) {
                        $pauta[$k]['area'] = $area['Areaestagio']['area'];
                        $pauta[$k]['area_id'] = $area['Areaestagio']['id'];
                    } else {
                        $pauta[$k]['area'] = NULL;
                        $pauta[$k]['area_id'] = NUll;
                    }
                    $pauta[$k]['estagiariosperiodo'] = $p;
                    $p++;
                } else {
                    // echo "Sem estagiários no período" . "<br />";
                }
                // echo "Periodo " . $p . "<br>";
                $i++;
            }
        }
        // pr($pauta);
        // die('pauta');
        $this->set('todosPeriodo', $todosPeriodo);
        $this->set('periodo', $periodo);
        if ($pauta):
            $this->set('professores', $pauta);
        else:
            $this->Session->setFlash(__("Sem pauta"), "flash_notification");
        endif;
    }

    public function busca($id = NULL) {

        if (isset($id))
            $this->request->data['Professor']['nome'] = $id;

        // $id = isset($this->request->data['Supervisor']['nome']) ? $this->request->data['Supervisor']['nome'] : null;
        // pr($id);
        if (!empty($this->request->data['Professor']['nome'])) {
            $condicao = ['Professor.nome like' => '%' . $this->request->data['Professor']['nome'] . '%'];
            $professores = $this->Professor->find('all', [
                'recursive' => -1, // Para excluir as associações
                'conditions' => $condicao,
                'order' => 'Professor.nome']);

            // pr($professores);
            // die('professores');

            /* Nenhum resultado */
            if (empty($professores)) {
                $this->Session->setFlash(__("Não foram encontrados registros"), "flash_notification");
            } else {
                // pr($professores);
                // die('professores');
                $this->Paginator->settings = ['Professor' => [
                        'recursive' => -1, // Para excluir as associações
                        'conditions' => ['Professor.nome like' => '%' . $this->request->data['Professor']['nome'] . '%'],
                        'order' => 'Professor.nome'
                    ]
                ];
                $this->set('professores', $this->Paginator->paginate('Professor'));
                $this->set('busca', $this->request->data['Professor']['nome']);
            }
        }
    }

}

?>
