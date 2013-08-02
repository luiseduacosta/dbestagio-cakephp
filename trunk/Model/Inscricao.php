<?php

class Inscricao extends AppModel {

	/* @var Mural */
	/* @var Aluno */
	/* @var Alunonovo */

	public $name = 'Inscricao';
	public $useTable = 'mural_inscricao';
	public $primaryKey = 'id';

        public $belongsTo = array(
			'Mural' => array(
					'className' => 'Mural',
					'foreignKey' => 'id_instituicao',
			),
			'Aluno' => array(
					'className' => 'Aluno',
					'foreignKey' => FALSE,
					'conditions' => 'Inscricao.id_aluno = Aluno.registro'
			),
			'Alunonovo' => array(
					'className' => 'Alunonovo',
					'foreignKey' => FALSE,
					'conditions' => 'Inscricao.id_aluno = Alunonovo.registro'
			),
			'Estagiario' => array(
					'className' => 'Estagiario',
					'foreignKey' => FALSE,
					'conditions' => array('Inscricao.id_aluno = Estagiario.registro', 'Inscricao.periodo = Estagiario.periodo')
			)
	);

}

?>
