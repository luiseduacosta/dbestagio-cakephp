<?php

class Professor extends AppModel {

    public $name = 'Professor';
    public $useTable = 'docentes';
    public $primaryKey = 'id';
    public $displayField = 'nome';
    
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'id_professor',
    ));

    public function beforeValidate($options = array()) {

        $this->data['Professor']['nome'] = ucwords(strtolower($this->data['Professor']['nome']));
        $this->data['Professor']['email'] = strtolower($this->data['Professor']['email']);

        return true;
    }

}

?>
