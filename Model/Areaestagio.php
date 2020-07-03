<?php

class Areaestagio extends AppModel {
    /* @var Estagiario */
    /* @var Instituicao */

    public $name = 'Areaestagio';
    public $useTable = 'areaestagios';
    public $primaryKey = 'id';
    public $displayField = 'area';
    public $actsAs = array('Containable');    
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'areaestagio_id'
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
