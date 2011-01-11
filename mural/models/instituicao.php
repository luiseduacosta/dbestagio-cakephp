<?php

class Instituicao extends AppModel {

	var $name = "Instituicao";
	var $useTable = "estagio";
	var $primaryKey = "id";
	var $displayField = "instituicao";

	var $hasMany = array(
		'Estagiario'=>array(
			'className'=>'Estagiario',
			'foreignKey'=>'id_instituicao'
		),
		'Mural'=>array(
			'className'=>'Mural',
			'foreignKey'=>'id_estagio'
		)
	);

	var $belongsTo = array(
		'Area'=>array(
		'className'=>'Area',
		'foreignKey'=>'area'
		)
	);

	var $hasAndBelongsToMany = array(
	        'Supervisor' =>array(
	        'className'=> 'Supervisor',
	        'joinTable'=> 'inst_super',
	        'foreignKey'=> 'id_instituicao',
	        'associationForeignKey'  => 'id_supervisor',
	        'unique'=> true,
	        'fields'=> '',
	        'order'=> 'Supervisor.nome'
	));

}

?>
