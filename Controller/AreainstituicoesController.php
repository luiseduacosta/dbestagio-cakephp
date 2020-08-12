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

        $this->Areainstituicao->virtualFields['quantidadearea'] = 'count(Instituicaoestagio.areainstituicao_id)';

        $areas = $this->Areainstituicao->find('all', array(
            'joins' => array(
                array(
                    'table' => 'instituicaoestagios',
                    'alias' => 'Instituicaoestagio',
                    'type' => 'left',
                    'conditions' => array('Instituicaoestagio.areainstituicao_id = Areainstituicao.id')
                )
            ),
            'fields' => array('Areainstituicao.id', 'Areainstituicao.area', 'count(Instituicaoestagio.areainstituicao_id) as Areainstituicao__quantidadearea'),
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
                $this->Session->setFlash(__("Atualizado"), "flash_notification");
                $this->redirect('/Areainstituicoes/view/' . $id);
            }
        }
    }

    public function add() {

        if ($this->data) {
            if ($this->Areainstituicao->save($this->data)) {
                $this->Session->setFlash(__('Dados inseridos'), "flash_notification");
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
          $this->Session->setFlash(__("Error: Há estagiários vinculados com esta área", "flash_notification");
          // die("Estagiarios vinculados com essa área");
          $this->redirect('/AreaInstituicao/view/' . $id);
          } else {
         */
        $this->AreaInstituicao->delete($id);
        $this->Session->setFlash(__("Área excluída"), "flash_notification");
        // die("Área excluída");
        $this->redirect('/Areainstituicaos/index/');
    }

//    }
}

?>
