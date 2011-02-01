<?php

class AreasController extends AppController {

    var $name = "Areas";

    // var $scaffold;

    function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Acl->check($this->Session->read('user'), 'controllers', '*')) {
            $this->Auth->allowedActions = array('*');
            $this->Session->setFlash("Administrador");
        // Professores somente (podem fazer tudo)
        } elseif ($this->Acl->check($this->Session->read('user'), 'areas', 'create')) {
            $this->Auth->allowedActions = array('*');
            $this->Session->setFlash("Professor");
        // Estudantes e supervisores podem ver
        } elseif ($this->Acl->check($this->Session->read('user'), 'areas', 'read')) {
            $this->Auth->allowedActions = array('index', 'view');
            $this->Session->setFlash("Estudante/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
        }
        // die(pr($this->Session->read('user')));
    }

    function index($id = NULL) {

        $areas = $this->Area->find('all', array(
                    'order' => 'Area.area'));

        $this->set('areas', $areas);
    }

    function view($id = NULL) {

        $area = $this->Area->find('first', array(
                    'conditions' => array('Area.id' => $id)
                ));
        // pr($supervisor);

        $this->set('area', $area);
    }

    function edit($id = NULL) {

        $this->Area->id = $id;

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

    function add($id = NULL) {

        if ($this->data) {
            if ($this->Area->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/Areas/view/' . $this->Area->getLastInsertId());
            }
        }
    }

    function delete($id = NULL) {

        $area = $this->Area->find('first', array(
                    'conditions' => array('Area.id' => $id)
                ));

        $this->loadModel('Estagiario');
        $estagiarios = $this->Estagiario->find('first', array(
                    'conditions' => 'Estagiario.id_area = ' . $id));

        if ($estagiarios) {
            $this->Session->setFlash("Error: Há estagiários vinculados com esta área");
            $this->redirect('/Areas/view/' . $id);
        } else {
            $this->Area->delete($id);
            $this->Session->setFlash("Área excluida");
            $this->redirect('/Areas/index/');
        }
    }

}

?>
