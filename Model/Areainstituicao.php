<?php

class Areainstituicao extends AppModel {
    /* @var Estagiario */
    /* @var Instituicao */

    public $name = 'Areainstituicao';
    public $useTable = 'areainstituicoes';
    public $primaryKey = 'id';
    public $displayField = 'area';
    public $hasMany = array(
        'Instituicaoestagio' => array(
            'className' => 'Instituicaoestagio',
            'foreignKey' => 'areainstituicao_id'
        )
    );

}
