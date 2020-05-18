<?php

class Role extends AppModel {

    public $name = 'Role';
    public $useTable = 'roles';

    public $hasMany = array('Userestagio' => array(
        'className' => 'Userestagio',
        'foreignKey' => 'categoria'));
}

?>
