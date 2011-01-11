<?php

class Supervisor extends AppModel {

	var $name = 'Supervisor';
	var $useTable = 'supervisores';
	var $primaryKey = 'id';
	var $displayField = 'nome';

	var $hasMany = array(
		'Estagiario'=>array(
			'className'=>'Estagiario',
			'foreignKey'=>'id_supervisor')
		);

      	var $hasAndBelongsToMany = array(
	        'Instituicao' =>array(
	        'className'=> 'Instituicao',
	        'joinTable'=> 'inst_super',
	        'foreignKey'=> 'id_supervisor',
	        'associationForeignKey'  => 'id_instituicao',
	        'unique'=> true,
	        'fields'=> '',
	        'order'=> ''
	));

	var $validate = array(
		
		'cress' => array(
			'cress1' => array(
				'rule' => 'numeric',
				'required' => TRUE,
				'allowEmpty' => TRUE,
				'message' => 'Digite somente números'
			),
			'cress2' => array(
				'rule' => 'verifica_cress',
				'on' => 'create',
				'message' => 'CRESS já cadastrado'
			)
		)
	);
	
	function verifica_cress($check) {

		$value = array_values($check);
        $value = $value[0];
		
		if (!empty($value)) {
            echo "Consulta";
            $cress = $this->find('first', array('conditions' => 'Supervisor.cress = ' . $value));
        }
        pr($cress);
        // die();
		if ($cress) {
			return FALSE;
		}
        
        return TRUE;
	}
}

?>
