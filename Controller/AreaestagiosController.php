<?php

class AreaestagiosController extends AppController {

    public $name = "Areaestagios";
    public $components = array('Auth');
    public $paginate = [
        'limit' => 25,
        'order' => ['Areaestagio.area']
    ];

    // var $scaffold;

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash(__("Administrador"), "flash_notification");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash(__("Estudante"), "flash_notification");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash(__("Professor"), "flash_notification");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash(__("Professor/Supervisor"), "flash_notification");
        } else {
            $this->Session->setFlash(__("Não autorizado"), "flash_notification");
            // $this->redirect('/Userestagios/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $areas = $this->Areaestagio->find('all');
        // pr($areas);
        // die('areas');

        $this->loadModel('Professor');
        $i = 0;
        foreach ($areas as $c_area):
            // pr($c_area['Areaestagio']);
            $areaestagios[$i]['areaestagio_id'] = $c_area['Areaestagio']['id'];
            $areaestagios[$i]['areaestagio'] = $c_area['Areaestagio']['area'];
            $areaestagios[$i]['q_estagiarios'] = count($c_area['Estagiario']);
            // pr(count($c_area['Estagiario']));
            // pr($areaestagios);
            // die();
            $j = 0;
            $professor_id = null;
            array_multisort(array_column($c_area['Estagiario'], 'docente_id'), $c_area['Estagiario']);
            // pr($c_area['Estagiario']);
            // die();
            foreach ($c_area['Estagiario'] as $estagiario):
                // pr($c_area['Estagiario']);
                $this->Professor->recursive = -1;
                $professor = $this->Professor->find('first', [
                    'fields' => ['Professor.id', 'Professor.nome'],
                    'conditions' => ['Professor.id' => [$estagiario['docente_id']]
                    ]
                ]);
                // pr($professor);
                // die('professor');
                // echo $professor_id . " -> " . $professor['Professor']['nome'] . "<br />";
                if (isset($professor['Professor']['id']) && $professor_id === $professor['Professor']['id']) {
                    // echo "Repetido " . "<br>";
                } elseif (isset($professor['Professor']['id'])) {
                    $professor_id = $professor['Professor']['id'];
                    // echo $professor_id . " " . $professor['Professor']['id'] . "<br />";
                    $areaestagios[$i]['docente'][$j]['professor_id'] = $professor['Professor']['id'];
                    $areaestagios[$i]['docente'][$j]['professor'] = $professor['Professor']['nome'];
                    // die();
                    $j++;
                }
            endforeach;
            $i++;
        endforeach;
        // pr($estagiarios);
        // pr($areaestagios);
        // die('areas');

        $this->set('areas', $areaestagios);
    }

    public function lista() {

        $areas = $this->Areaestagio->find("all", array(
            "order" => array("Areaestagio.area")));

        // $this->set("areas", $areas);
        $this->set('areas', $this->Paginator->paginate('Areaestagio'));
    }

    public function view($id = NULL) {

        $area = $this->Areaestagio->find('first', array(
            'conditions' => array('Areaestagio.id' => $id)
        ));
        // pr($supervisor);

        $this->set('area', $area);
    }

    public function edit($id = NULL) {

        $this->Areaestagio->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Areaestagio->read();
        } else {
            if ($this->Areaestagio->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash(__("Atualizado"), "flash_notification");
                $this->redirect('/Areaestagios/view/' . $id);
            }
        }
    }

    public function add() {

        if ($this->data) {
            if ($this->Areaestagio->save($this->data)) {
                $this->Session->setFlash(__("Dados inseridos"), "flash_notification");
                $this->redirect('/Areaestagios/view/' . $this->Areaestagio->getLastInsertId());
            }
        }
    }

    public function delete($id = NULL) {

        $area = $this->Areaestagio->find('first', array(
            'conditions' => array('Areaestagio.id' => $id)
        ));

        // $this->loadModel('Estagiario');
        $estagiarios = $this->Areaestagio->Estagiario->find('first', array(
            'conditions' => 'Estagiario.id_area = ' . $id));
        // pr($estagiarios);

        if ($estagiarios) {
            $this->Session->setFlash(__("Error: Há estagiários vinculados com esta área"), "flash_notification");
            // die("Estagiarios vinculados com essa área");
            $this->redirect('/Areaestagios/view/' . $id);
        } else {
            $this->Areaestagio->delete($id);
            $this->Session->setFlash(__("Área excluída"), "flash_notification");
            // die("Área excluída");
            $this->redirect('/Areaestagios/index/');
        }
    }
}

?>
