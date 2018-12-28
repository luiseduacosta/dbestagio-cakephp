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
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Session->setFlash("Estudante não autorizado");
            $this->redirect('/murais/index/');
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add', 'edit', 'excluir', 'index', 'view');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'busca');
            // $this->Session->setFlash("Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/users/login/');
        }
    }

    public function index() {

        // $visitas = $this->Visita->find('all');
        // pr($visitas);
        // die();

        $this->Paginator->settings = array('order' => 'Visita.data');
        $data = $this->Paginator->paginate('Visita');
        $this->set('visitas', $data);
    }

    public function add($id = NULL) {

        // Capturo e envio o id da instituicao se houver
        $instituicao_id = $this->params['named']['instituicao'];
        if ($instituicao_id) {
            // pr($instituicao_id);
            $this->set('instituicao_id', $instituicao_id);

            // Mostar as visitas anteriores
            $visitas = $this->Visita->find('all', array(
                'conditions' => array('Visita.estagio_id' => $instituicao_id)
                    /* 'fields' => 'Instituicao.id', 'Instituicao.instituicao', 'Visita.id', 'Visita.data', 'Visita.motivo', 'Visita.responsavel', 'Visita.descricao', 'Visita.avaliacao') */
                    )
            );

            if (!empty($visitas)) {
                $this->set('visitas', $visitas);
            };
            // pr($visitas);
            // $log = $this->Visita->getDataSource()->getLog(false, false);
            // debug($log);
            // die();
        }
        // die();
        // Lista de selecao das insttuicoes
        $instituicoes = $this->Visita->Instituicao->find('list', array('order' => 'instituicao'));

        if ($this->data) {
            if ($this->Visita->save($this->data)) {
                $this->Session->setFlash('Dados da visita institucional inseridos!');
                // $this->Visita->getLastInsertId();
                $this->redirect('/Visitas/view/' . $this->Visita->getLastInsertId());
            }
        }

        $this->set('instituicoes', $instituicoes);
    }

    public function edit($id = NULL) {

        $this->Visita->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Visita->read();
        } else {
            if ($this->Visita->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/visitas/view/' . $id);
            }
        }
    }

    public function excluir($id = NULL) {
        $this->Visita->delete($id);
        $this->Session->setFlash('Visita institucional excluída');
        $this->redirect('/Visitas/index/');
    }

    public function view($id = NULL) {
        $visita = $this->Visita->find('first', array(
            'conditions' => array('Visita.id' => $id)));
        // pr($visita);
        $this->set('visita', $visita);
    }

}
