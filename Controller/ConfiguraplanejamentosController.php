<?php

class ConfiguraplanejamentosController extends AppController {

    public $name = "Configuraplanejamentos";
    
    public $components = array('Auth');
    
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
            $this->redirect('/users/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $configuracoes = $this->Configuraplanejamento->find('all');
        // $planejamento = $this->Configuraplanejamento->Planejamento->find('first', array('conditions' => array('Planejamento.configuraplanejamnto_id')));
        // pr($configuracoes);
        $this->set('configuraplanejamentos', $configuracoes);
    }

    public function edit($id = NULL) {

        $this->Configuraplanejamento->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Configuraplanejamento->read();
        } else {
            if ($this->Configuraplanejamento->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/configuraplanejamentos/view/' . $id);
            }
        }
    }

    public function view($id = NULL) {

        $configuraplanejamento = $this->Configuraplanejamento->find('first', array(
            'conditions' => array('Configuraplanejamento.id' => $id)
        ));
        $this->set('configuraplanejamento', $configuraplanejamento);
    }

    public function add() {

        $this->set('configuracoes', $configuracoes = $this->Configuraplanejamento->find('all'));

        if ($this->data) {
            if ($this->Configuraplanejamento->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/configuraplanejamentos/index');
            }
        }
    }

    public function delete($id = NULL) {

        $verifica = $this->Configuraplanejamento->Planejamento->find('first', array('conditions' => array('Planejamento.configuraplanejamento_id' => $id)));
        if ($verifica):
            $this->Session->setFlash('Registro não pode ser excluído porque está associado a uma planilha');
            $this->redirect('/planejamentos/listar/semestre:' . $id);
        else:
            $this->Configuraplanejamento->delete($id);
            $this->Session->setFlash("Registro excluído");
            $this->redirect('/configuraplanejamentos/index/');
        endif;
    }

}
