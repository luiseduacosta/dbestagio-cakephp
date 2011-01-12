<?php

class SupervisorsController extends AppController {

	var $name = 'Supervisors';
	// var $scaffold;

	function index($id = NULL) {

		$this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Supervisor.nome' => 'asc')
		);

		$this->set('supervisores', $this->Paginate('Supervisor'));

	}

	function view($id = NULL) {
		
		$supervisor = $this->Supervisor->find('first', array(
		'conditions'=>array('Supervisor.id'=>$id)
		));

		// Para o select de inserir uma nova instituicao
		$this->loadModel('Instituicao');
		$instituicoes = $this->Instituicao->find('list', array('order'=>'Instituicao.instituicao'));
		$instituicoes[0] = '- Selecione -';
		asort($instituicoes);
		$this->set('instituicoes', $instituicoes);

		// pr($supervisor);

		$proximo = $this->Supervisor->find('neighbors', array(
                    'field' => 'nome', 'value' => $supervisor['Supervisor']['nome']));

		$this->set('registro_next', $proximo['next']['Supervisor']['id']);
		$this->set('registro_prev', $proximo['prev']['Supervisor']['id']);

		$this->set('supervisor', $supervisor);

	}

	function add($id = NULL) {

		$this->loadModel('Instituicao');
		$instituicoes = $this->Instituicao->find('list', array('order'=>'Instituicao.instituicao'));
		$instituicoes[0] = '- Seleciona -';
		asort($instituicoes);
		$this->set('instituicoes', $instituicoes);

		if ($this->data) {
			// pr($this->data);
			// die();
			if ($this->Supervisor->save($this->data)) {
				$this->Session->setFlash('Dados inseridos');
				$this->redirect('/Supervisors/view/' . $this->Supervisor->getLastInsertId());
			}
		}

	}

	function busca($id = NULL) {

		if ($id) $this->data['Supervisor']['nome'] = $id;

		$this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Supervisor.nome' => 'asc')
		);

		if ($this->data['Supervisor']['nome']) {

			$condicao = array('Supervisor.nome like' => '%' . $this->data['Supervisor']['nome'] . '%');
			$supervisores = $this->Supervisor->find('all', array('conditions' => $condicao));

			// Nenhum resultado
			if (empty($supervisores)) {
				$this->Session->setFlash("Não foram encontrados registros");
			} else {
				$this->set('supervisores', $this->Paginate($condicao));
				$this->set('busca', $this->data['Supervisor']['nome']);
			}
		}
	}

	function edit($id = NULL) {
		$this->Supervisor->id = $id;

		if (empty($this->data)) {
			$this->data = $this->Supervisor->read();
		} else {
			if ($this->Supervisor->save($this->data)) {
				// print($id);
				// die();
				// print_r($this->data);
				$this->Session->setFlash("Atualizado");
				$this->redirect('/Supervisors/view/' . $id);
			}
		}
	}

	function delete($id = NULL) {

		$supervisores = $this->Supervisor->find('first', array(
            'conditions' => array('Supervisor.id' => $id)
		));

		// pr($supervisores);
		// die();

		if ($supervisores['Estagiario']) {
			$this->Session->setFlash('Há estagiários vinculados a este supervisor');
			$this->redirect('/Supervisors/view/' . $id);
			exit;
		} elseif ($supervisores['Instituicao']) {
			$this->Session->setFlash('Há instituições vinculadas a este supervisor');
			$this->redirect('/Supervisors/view/' . $id);
			exit;
		} else {
			$this->Supervisor->delete($id);
			$this->Session->setFlash("Supervisor excluido");
			$this->redirect('/Supervisors/index/');
		}

	}

	function addinstituicao($id = NULL) {

		if ($this->data) {
			// pr($this->data);
			// die();
			if ($this->Supervisor->InstSuper->save($this->data)) {
				$this->Session->setFlash('Dados inseridos');
				$this->redirect('/Supervisors/view/' . $this->data['InstSuper']['id_supervisor']);
			}
		}

	}

	function deleteassociacao($id = NULL) {

		$id_superinstituicao = $this->Supervisor->InstSuper->find('first', array('conditions'=>'InstSuper.id= '. $id));
		// pr($id_superinstituicao);
		// die();
		$this->Supervisor->InstSuper->delete($id);

		$this->Session->setFlash("Instituição excluída do supervisor");
		$this->redirect('/Supervisors/view/' . $id_superinstituicao['InstSuper']['id_supervisor']);

	}

}

?>
