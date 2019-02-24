<?php

class Areainstituicao extends AppModel {

    public $name = 'Areainstituicao';
    public $useTable = 'area_instituicoes';
    public $primaryKey = 'id';
    public $displayField = 'area';
    public $hasMany = array(
        'Instituicao' => array(
            'className' => 'Instituicao',
            'foreignKey' => 'area_instituicoes_id'
        )
    );

}

?>
