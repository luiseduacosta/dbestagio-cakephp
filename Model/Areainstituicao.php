<?php

class AreaInstituicao extends AppModel {

	/* @var Estagiario */
	/* @var Instituicao */

	public $name = 'AreaInstituicao';
	public $useTable = 'area_instituicoes';
	public $primaryKey = 'id';
	public $displayField = 'area';
	public $hasMany = array(
			'Instituicao' => array(
					'className' => 'Instituicao',
					'foreignKey' => 'area_instituicoes_id'
			)
	);

