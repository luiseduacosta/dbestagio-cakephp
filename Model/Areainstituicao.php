<?php

class Areainstituicao extends AppModel {
    /* @var Estagiario */
    /* @var Instituicao */

    public $name = 'Areainstituicao';
    public $useTable = 'areainstituicoes';
    public $primaryKey = 'id';
    public $displayField = 'area';
    public $hasMany = array(
        'Instituicao' => array(
            'className' => 'Instituicao',
            'foreignKey' => 'areainstituicoes_id'
        )
    );

}
