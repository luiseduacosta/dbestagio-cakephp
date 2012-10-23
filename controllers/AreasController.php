<?php

class AreasController extends AppController {

    public $name = "Areas";

    // var $scaffold;

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
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            // $this->redirect('/users/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $areas = $this->Area->find('all', array(
            'order' => 'Area.area'));

        $this->set('areas', $areas);
    }

    public function view($id = NULL) {

        $area = $this->Area->find('first', array(
            'conditions' => array('Area.id' => $id)
                ));
        // pr($supervisor);

        $this->set('area', $area);
    }

    public function edit($id = NULL) {

        $this->request->Area->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Area->read();
        } else {
            if ($this->Area->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Areas/view/' . $id);
            }
        }
    }

    public function add() {

        if ($this->data) {
            if ($this->Area->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/Areas/view/' . $this->Area->getLastInsertId());
            }
        }
    }

    public function delete($id = NULL) {

        $area = $this->Area->find('first', array(
            'conditions' => array('Area.id' => $id)
                ));

        // $this->loadModel('Estagiario');
        $estagiarios = $this->Area->Estagiario->find('first', array(
            'conditions' => 'Estagiario.id_area = ' . $id));
        // pr($estagiarios);

        if ($estagiarios) {
            $this->Session->setFlash("Error: Há estagiários vinculados com esta área");
            // die("Estagiarios vinculados com essa área");
            $this->redirect('/Areas/view/' . $id);
        } else {
            $this->Area->delete($id);
            $this->Session->setFlash("Área excluída");
            // die("Área excluída");
            $this->redirect('/Areas/index/');
        }
    }

}

?>
