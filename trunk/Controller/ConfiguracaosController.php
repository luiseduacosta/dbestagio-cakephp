<?php

class ConfiguracaosController extends AppController {

	public $name = "Configuracaos";

	// var $scaffold;

	public function beforeFilter() {

		parent::beforeFilter();
		// Admin
		if ($this->Session->read('id_categoria') === '1') {
			$this->Auth->allow();
			$this->Session->setFlash("Administrador");
		} else {
			$this->Session->setFlash("Administração: Não autorizado");
		}
		// die(pr($this->Session->read('user')));
	}

	public function view($id = NULL) {

		$configuracao = $this->Configuracao->find('first');
		// pr($configuracao);

		$this->set('configuracao', $configuracao);
	}

	public function edit($id = NULL) {

		$this->Configuracao->id = $id;

		if (empty($this->data)) {
			$this->data = $this->Configuracao->read();
		} else {
			if ($this->Configuracao->save($this->data)) {
				// print_r($this->data);
				$this->Session->setFlash("Atualizado");
				$this->redirect('/Configuracaos/view/' . $id);
			}
		}
	}

}

?>
