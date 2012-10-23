<?php

class ProfessorsController extends AppController {

    public $name = "Professors";

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
            $this->redirect('/users/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->Paginate = array(
            'limit' => 10,
            'order' => array('Professor.nome' => 'asc'));

        $this->set('professores', $this->Paginate('Professor'));
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

        $this->request->Professor->id = $id;

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

    public function add($id = NULL) {

        if ($this->data) {
            if ($this->Professor->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->Professor->getLastInsertId();
                $this->redirect('/Professors/view/' . $this->Professor->getLastInsertId());
            }
        }
    }

    public function pauta($id = NULL) {
        
    }

}

?>
