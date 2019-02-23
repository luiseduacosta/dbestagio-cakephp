<?php

class Area extends AppModel {
    /* @var Estagiario */
    /* @var Instituicao */

    public $name = 'Area';
    public $useTable = 'areas_estagio';
    public $primaryKey = 'id';
    public $displayField = 'area';
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'id_area'
        )
    );

    /*
      'Instituicao' => array(
      'className' => 'Instituicao',
      'foreignKey' => 'area'
      ));
     */
}

?>
