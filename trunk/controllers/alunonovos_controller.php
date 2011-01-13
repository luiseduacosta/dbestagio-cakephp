<?php

class AlunonovosController extends AppController {

	var $name = "Alunonovos";

	// var $scaffold;

	function index($id = NULL) {

		$alunonovo = $this->Alunonovo->find('all', array('order' => 'Alunonovo.nome'));
		/*
		 pr($alunonovo['Alunonovo']);
		 pr($alunonovo['Mural']);
		 */
		$this->set('alunonovo', $alunonovo);
	}

	/*
	 * Além de ser chamada por ela propria
	 * esta funcao eh chamada desde inscricao para selecao de estagio
	 * e tambem desde termo de compromisso
	 */

	function add($id = NULL) {

		$this->set('registro', $id);

		if ($this->Alunonovo->save($this->data)) {

			// Capturo o id da instituicao (se foi chamada desde inscriacao add)
			$inscricao_selecao_estagio = $this->Session->read('id_instituicao');
			// Ainda nao posso apagar
			// $this->Session->delete('id_instituicao');
			// Capturo se foi chamado desde a solicitacao do termo
			$registro_termo = $this->Session->read('termo');
			// Acho que posso apagar aqui porque nao vai ser chamado novamente
			$this->Session->delete('termo');

			$registro = $this->data['Alunonovo']['registro'];
			$this->Session->setFlash("Cadastro realizado");

			if ($inscricao_selecao_estagio) {
				// Volta para a pagina de inscricao
				$this->redirect('/Inscricaos/inscricao/' . $registro);
			} elseif ($registro_termo) {
				// Volta para a pagina de termo de compromisso
				$this->redirect('/Inscricaos/termocompromisso/' . $registro_termo);
			} else {
				// Mostra resultado da insercao
				$this->Session->setFlash('Dados inseridos');
				$id_alunonovo = $this->Alunonovo->getLastInsertId();
				$this->redirect('/Alunonovos/view/' . $id_alunonovo);
			}
		}
	}

	/*
	 * Além de ser chamada por ela propria
	 * esta funcao eh chamada desde inscricao para selecao de estagio
	 * e tambem desde termo de compromisso
	 */

	/*
	 * id eh o id do alunonovo
	 */

	function edit($id = NULL) {

		$this->Alunonovo->id = $id;

		if (empty($this->data)) {
			$this->data = $this->Alunonovo->read();
		} else {

			if ($this->Alunonovo->save($this->data)) {
				// print_r($this->data);
				$this->Session->setFlash("Atualizado");

				// Capturo o id da instituicao (se foi chamada desde inscriacao add)
				$inscricao_selecao_estagio = $this->Session->read('id_instituicao');
				// Ainda nao posso apagar
				// $this->Session->delete('id_instituicao');
				// Capturo se foi chamado desde a solicitacao do termo
				$registro_termo = $this->Session->read('termo');
				$this->Session->delete('termo');
				if ($inscricao_selecao_estagio) {
					// Faz inscricao para selecao de estagio
					$this->Session->setFlash("Inscricao para selecao de estagio");
					$this->redirect('/Inscricaos/inscricao/' . $this->data['Alunonovo']['registro']);
				} elseif (!empty($registro_termo)) {
					// Solicita termo de compromisso
					$this->Session->setFlash("Solicitacao de termo de compromisso");
					// $this->redirect('/Inscricaos/termocompromisso/' . $registro_termo);
				} else {
					// Simplesmente atualiza e mostra o resultado
					$this->redirect('/Alunonovos/view/' . $id);
				}
			}
		}
	}

	function view($id = NULL) {

		$aluno = $this->Alunonovo->findById($id);
		// pr($aluno);

		$this->set('alunos', $aluno);
	}

	function delete($id = NULL) {

		// Pego o numero de registro
		$registro = $this->Alunonovo->findById($id, array('fields' => 'registro'));
		// Pego as inscricoes realizadas

		$this->loadModel('Inscricao');
		$inscricao = $this->Inscricao->find('all', array(
                    'conditions' => array('Inscricao.id_aluno' => $registro['Alunonovo']['registro']),
                    'fields' => 'id'));
		// pr($inscricao);
		// die();
		
		if ($inscricao) {
			foreach ($inscricao as $c_inscricao) {
				// pr($c_inscricao['Inscricao']['id']);
				// die();
				$this->Inscricao->delete($c_inscricao['Inscricao']['id']);
			}
		}

		$this->Alunonovo->delete($id);

		$this->Session->setFlash("Registro excluído (junto com as inscrições)");
		$this->redirect("/Inscricaos/index/");
	}

}

?>
