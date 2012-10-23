<?php

class Professor extends AppModel {
	/*
	 * @var Estagiario
	*
	*/

	public $name = 'Professor';
	public $useTable = 'professores';
	public $primaryKey = 'id';
	public $displayField = 'nome';
	public $hasMany = array(
			'Estagiario' => array(
					'className' => 'Estagiario',
					'foreignKey' => 'id_professor',
			));

}

?>
