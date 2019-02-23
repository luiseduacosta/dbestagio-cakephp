<?php

class Role extends AppModel {

    public $name = 'Role';
    public $useTable = 'roles';

    public $hasMany = array('User' => array(
        'className' => 'User',
        'foreignKey' => 'categoria'));
}

?>
