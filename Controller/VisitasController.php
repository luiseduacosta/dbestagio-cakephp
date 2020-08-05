<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VisitasController extends AppController {

    public $name = "Visitas";
    public $components = array('Auth', 'Paginator');

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash(__("Administrador"), "flash_notification");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Session->setFlash(__("Estudante não autorizado"), "flash_notification");
            $this->redirect('/murais/index/');
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add', 'edit', 'excluir', 'index', 'view');
            // $this->Session->setFlash(__("Professor"), "flash_notification");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'busca');
            // $this->Session->setFlash(__("Supervisor"), "flash_notification");
        } else {
            $this->Session->setFlash(__("Não autorizado"), "flash_notification");
            $this->redirect('/Userestagios/login/');
        }
    }

    public function index() {

        $this->Paginator->settings = array('order' => 'Visita.data');
        $data = $this->Paginator->paginate('Visita');
        $this->set('visitas', $data);
    }

    public function add($id = NULL) {

        $parametros = $this->params['named'];
        $instituicao_id = isset($parametros['instituicao_id']) ? $parametros['instituicao_id'] : NULL;

        /* Meses em portugués */
        $this->set('meses', $this->meses());

        // Capturo e envio o id da instituicao se houver
        if ($instituicao_id == NULL) {
            $instituicao_id = $id;
            // pr($instituicao_id);
            $this->set('instituicao_id', $instituicao_id);
        } else {
            $this->Session->setFlash(__('Selecione uma instituição'), "flash_notification");
            $this->redirect('/instituicoes/lista');
        }
        // Mostar as visitas anteriores
        $visitas = $this->Visita->find('all', array(
            'conditions' => array('Visita.estagio_id' => $instituicao_id)
                )
        );

        if (!empty($visitas)) {
            $this->set('visitas', $visitas);
        };
        // pr($visitas);
        // $log = $this->Visita->getDataSource()->getLog(false, false);
        // debug($log);
        // die();
        // die();
        // Lista de selecao das insttuicoes
        $instituicoes = $this->Visita->Instituicao->find('list', array('order' => 'instituicao'));

        if ($this->data) {
            if ($this->Visita->save($this->data)) {
                $this->Session->setFlash(__('Dados da visita institucional inseridos!'), "flash_notification");
                // $this->Visita->getLastInsertId();
                $this->redirect('/Visitas/view/' . $this->Visita->getLastInsertId());
            }
        }

        $this->set('instituicoes', $instituicoes);
    }

    public function edit($id = NULL) {

        $this->Visita->id = $id;

        /* Meses em portugués */
        $this->set('meses', $this->meses());

        if (empty($this->data)) {
            $this->data = $this->Visita->read();
        } else {
            if ($this->Visita->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash(__("Atualizado"), "flash_notification");
                $this->redirect('/visitas/view/' . $id);
            }
        }
    }

    public function excluir($id = NULL) {
        $this->Visita->delete($id);
        $this->Session->setFlash(__('Visita institucional excluída'), "flash_notification");
        $this->redirect('/Visitas/index/');
    }

    public function view($id = NULL) {
        $visita = $this->Visita->find('first', array(
            'conditions' => array('Visita.id' => $id)));
        // pr($visita);
        $this->set('visita', $visita);
    }

}
