<?php

class ArosAco extends AppModel {

    var $name = 'ArosAco';
    var $useTable = 'aros_acos';
    var $primaryKey = 'id';
    
    var $belongsTo = array(
        'Aro' => array(
            'className' => 'Aro',
            'foreignKey' => 'aro_id',
            'joinTable' => 'aros'
        ),
        'Aco' => array(
            'className' => 'Aco',
            'foreignKey' => 'aco_id',
            'joinTable' => 'acos'
        )
    );

}

?>
