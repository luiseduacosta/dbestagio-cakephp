<?php

class ProfessorsController extends AppController {

    public $name = "Professors";
    public $components = array('Auth');
    public $paginate = array(
        'limit' => 10,
        'order' => array('Professor.nome' => 'asc'));

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'pauta');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add' . 'edit' . 'index', 'view', 'pauta');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'pauta');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/Professors/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        // $professores = $this->Professor->find('all');
        // pr($professores);
        // die();
        // $this->set('professores', $professores);
        $this->set('professores', $this->Paginate('Professor'));

        // die();
    }

    public function view($id = NULL) {

        // Configure::write('debug', 0);
        // Somente o próprio pode ver
        if ($this->Session->read('numero')) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Professor->findBySiape($this->Session->read('numero'));
            if ($id != $verifica['Professor']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Professors/index");
                die("Não autorizado");
            }
        }

        $professor = $this->Professor->find('first', array(
            'conditions' => array('Professor.id' => $id),
            'order' => 'Professor.nome'));

        // pr($professor);

        $proximo = $this->Professor->find('neighbors', array(
            'field' => 'nome', 'value' => $professor['Professor']['nome']));

        $this->set('registro_next', $proximo['next']['Professor']['id']);
        $this->set('registro_prev', $proximo['prev']['Professor']['id']);

        $this->set('professor', $professor);
    }

    public function edit($id = NULL) {

        $this->Professor->id = $id;

        // Somente o próprio pode ver
        if ($this->Session->read('numero')) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Professor->findBySiape($this->Session->read('numero'));
            if ($id != $verifica['Professor']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Professors/view/" . $id);
                die("Não autorizado");
            }
        }

        if (empty($this->data)) {
            $this->data = $this->Professor->read();
        } else {
            if ($this->Professor->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Professors/view/' . $id);
            }
        }
    }

    public function add() {

        if ($this->data) {
            if ($this->Professor->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->Professor->getLastInsertId();
                $this->redirect('/Professors/view/' . $this->Professor->getLastInsertId());
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

        if (!$periodo)
            $periodo = end($todosPeriodo);

        $this->Professor->recursive = 1;
        $estagiarios = $this->Professor->find('all');
        // pr($estagiarios);

        $k = 0;
        foreach ($estagiarios as $c_professor) {
            $professor = $c_professor['Professor']['nome'];
            $professor_id = $c_professor['Professor']['id'];
            $departamento = $c_professor['Professor']['departamento'];
            // $area = $c_professor['Professor']['id_area'];            

            $k++;
            // echo $professor . " ";
            $i = 0;
            $estagiariostotal = sizeof($c_professor['Estagiario']);
            // echo '<br>';
            $p = 1;
            foreach ($c_professor['Estagiario'] as $estagiariodoprofessor) {

                if ($estagiariodoprofessor['periodo'] == $periodo) {

                    $this->loadModel('Area');
                    $this->Area->recursive = -1;
                    $area = $this->Area->find('first', array('conditions' => array('Area.id' => $estagiariodoprofessor['id_area'])));
                    // pr($area);
                    // echo $k . " " . $professor . " -> " . " " . $periodo . " " . $p++ . "<br>";
                    $pauta[$k]['id'] = $k;
                    $pauta[$k]['professor'] = $professor;
                    $pauta[$k]['professor_id'] = $professor_id;
                    $pauta[$k]['departamento'] = $departamento;
                    $pauta[$k]['estagariariostotal'] = $estagiariostotal;
                    if ($area) {
                        $pauta[$k]['area'] = $area['Area']['area'];
                        $pauta[$k]['area_id'] = $area['Area']['id'];
                    } else {
                        $pauta[$k]['area'] = NULL;
                        $pauta[$k]['area_id'] = NUll;
                    }
                    $pauta[$k]['estagiariosperiodo'] = $p;
                    $p++;
                }
                // echo "Periodo " . $p . "<br>";
                $i++;
            }
        }

        $this->set('todosPeriodo', $todosPeriodo);
        $this->set('periodo', $periodo);
        $this->set('professores', $pauta);
    }

}

?>
