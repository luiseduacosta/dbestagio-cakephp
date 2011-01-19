<?php

class ProfessorsController extends AppController {

	var $name = "Professors";
	// var $scaffold;

	function index($id = NULL) {

		$this->Paginate = array(
			'limit'=>10,
			'order'=>array('Professor.nome'=>'asc'));

		$this->set('professores', $this->Paginate('Professor'));

	}

	function view($id = NULL) {

		// Configure::write('debug', 0);
		$professor = $this->Professor->find('first', array(
		'conditions'=>array('Professor.id'=>$id),
		'order'=>'Professor.nome'));

		// pr($professor);

        $proximo = $this->Professor->find('neighbors', array(
                    'field' => 'nome', 'value' => $professor['Professor']['nome']));

        $this->set('registro_next', $proximo['next']['Professor']['id']);
        $this->set('registro_prev', $proximo['prev']['Professor']['id']);

        $this->set('professor', $professor);

	}

	function edit($id = NULL) {

		$this->Professor->id = $id;

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

	function add($id = NULL) {

		if ($this->data) {
			if ($this->Professor->save($this->data)) {
				$this->Session->setFlash('Dados inseridos');
				$this->Professor->getLastInsertId();
				$this->redirect('/Professors/view/' . $this->Professor->getLastInsertId());
			}
		}

	}

}

?>
