<?php

class User extends AppModel {

	var $name = 'User';
	var $useTable = 'users';
	var $displayField = 'nome';

	var $validate = array(
		'nome' => array('rule'=>'notEmpty'),	
		'email'=> array('rule'=>'notEmpty'),
		'password'=> array('rule'=>'notEmpty'),	
	
	);

	function beforeValidate() {
    	if (!$this->id) {
        	if ($this->findCount(array(
        		'User.nome' => $this->data['User']['nome'])) > 0) {
            $this->invalidate('username_unique');
            return false;
        	}
    	}
    return true;
	}
	
}

?>
