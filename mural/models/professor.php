<?php

class Professor extends AppModel {

	var $name = 'Professor';
	var $useTable = 'professores';
	var $primaryKey = 'id';
	var $displayField = 'nome';
	var $hasMany = array(
		'Estagiario'=>array(
			'className'=>'Estagiario',
			'foreignKey'=>'id_professor',
		));

}

?>
