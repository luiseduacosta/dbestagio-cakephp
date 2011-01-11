<?php

class User extends AppModel {

	var $name = 'User';
	var $useTable = 'users';
	var $displayField = 'nome';

	var $validade = array(
		'username'=> array('rule'=>'notEmpty'),
		'password'=> array('rule'=>'notEmpty'),	
	);
}

?>
