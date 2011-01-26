<?php

class User extends AppModel {

	var $name = 'User';
	var $useTable = 'users';
	var $displayField = 'email';

	var $validate = array(
		'email'=> array('rule'=>'notEmpty'),
		'password'=> array('rule'=>'notEmpty'),

	);

	function beforeValidate() {
    		if (!$this->id) {
        		if ($this->findCount(array(
        			'User.email' => $this->data['User']['email'])) > 0) {
            		$this->invalidate('useremail_unique');
            		return false;
        		}
    		}
    	return true;
	}

}

?>
