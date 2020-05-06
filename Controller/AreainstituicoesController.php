<?php

class AreainstituicoesController extends AppController {

    public $name = "Areainstituicoes";
    public $components = array('Auth');
    public $paginate = [
        'limit' => 25,
        'order' => ['Areainstituicao.area']
    ];

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
            // $this->redirect('/Userestagios/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->Areainstituicao->virtualFields['quantidadearea'] = 'count(Instituicao.areainstituicoes_id)';

        $areas = $this->Areainstituicao->find('all', array(
            'joins' => array(
                array(
                    'table' => 'estagio',
                    'alias' => 'Instituicao',
                    'type' => 'left',
                    'conditions' => array('Instituicao.areainstituicoes_id = Areainstituicao.id')
                )
            ),
            'fields' => array('Areainstituicao.id', 'Areainstituicao.area', 'count(Instituicao.areainstituicoes_id) as Areainstituicao__quantidadearea'),
            'group' => array('Areainstituicao.id'),
            'order' => array('Areainstituicao.area')));

        // pr($areas);
        // die();
        $this->set('areas', $areas);
    }

    public function view($id = NULL) {

        $area = $this->Areainstituicao->find('first', array(
            'conditions' => array('Areainstituicao.id' => $id)
        ));
        // pr($supervisor);

        $this->set('area', $area);
    }

    public function edit($id = NULL) {

        $this->Areainstituicao->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Areainstituicao->read();
        } else {
            if ($this->Areainstituicao->save($this->data)) {
                // print_r($this->data);
                // die();
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Areainstituicoes/view/' . $id);
            }
        }
    }

    public function add() {

        if ($this->data) {
            if ($this->Areainstituicao->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/Areainstituicoes/view/' . $this->Areainstituicao->getLastInsertId());
            }
        }
    }

    public function delete($id = NULL) {

        $area = $this->Areainstituicao->find('first', array(
            'conditions' => array('Areainstituicao.id' => $id)
        ));

        // $this->loadModel('Estagiario');
        /*
          $estagiarios = $this->AreaInstituicao->Estagiario->find('first', array(
          'conditions' => 'Estagiario.id_area = ' . $id));
          // pr($estagiarios);

          if ($estagiarios) {
          $this->Session->setFlash("Error: Há estagiários vinculados com esta área");
          // die("Estagiarios vinculados com essa área");
          $this->redirect('/AreaInstituicao/view/' . $id);
          } else {
         */
        $this->AreaInstituicao->delete($id);
        $this->Session->setFlash("Área excluída");
        // die("Área excluída");
        $this->redirect('/Areainstituicaos/index/');
    }

//    }
}

?>
