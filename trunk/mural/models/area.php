<?php

class Area extends AppModel {

	var $name = 'Area';
	var $useTable = 'areas_estagio';
	var $primaryKey = 'id';
	var $displayField = 'area';

	var $hasMany = array(
		'Estagiario'=>array(
			'className'=>'Estagiario',
			'foreignKey'=>'id_area'
		),
		'Instituicao'=>array(
			'className'=>'Instituicao',
			'foreignKey'=>'area'
		)
	);

}

?>
