<?php

class Inscricao extends AppModel {

	var $name = 'Inscricao';
	var $useTable = 'mural_inscricao';
	var $primaryKey = 'id';

	var $belongsTo = array(
			'Mural'=>array(
				'className'=>'Mural',
				'foreignKey'=>'id_instituicao',
				),
			'Aluno'=>array(
				'className'=>'Aluno',
				'foreignKey'=>FALSE,
				'conditions'=>'Inscricao.id_aluno = Aluno.registro'
				),
			'Alunonovo'=>array(
				'className'=>'Alunonovo',
				'foreignKey'=>FALSE,
				'conditions'=> 'Inscricao.id_aluno = Alunonovo.registro'
				)
		);
}

?>
