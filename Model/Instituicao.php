<?php

class Instituicao extends AppModel {
    /* @var Estagiario */
    /* @var Mural */
    /* @var Area */
    /* @var Supervisor */

    public $name = "Instituicao";
    public $useTable = "estagio";
    public $primaryKey = "id";
    public $displayField = "instituicao";
    public $actsAs = array('Containable');
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'instituicao_id',
            'joinTable' => 'estagiarios'
        ),
        'Mural' => array(
            'className' => 'Muralestagio',
            'foreignKey' => 'id_estagio'
        ),
        'Visita' => array(
            'className' => 'Visita',
            'foreignKey' => 'estagio_id'
        )
    );
    public $belongsTo = array(
        'Areainstituicao' => array(
            'className' => 'Areainstituicao',
            'foreignKey' => 'areainstituicoes_id'
        )
    );
    public $hasAndBelongsToMany = array(
        'Supervisor' => array(
            'className' => 'Supervisor',
            'joinTable' => 'instituicao_supervisor',
            'foreignKey' => 'instituicao_id',
            'associationForeignKey' => 'supervisor_id',
            'unique' => true,
            'fields' => '',
            'order' => 'Supervisor.nome'
        )
    );
    public $validate = array(
        'instituicao' => array(
            'rule' => 'notBlank',
            'allowEmpty' => FALSE,
            'message' => 'Digite o nome da instituição'
        ),
        'url' => array(
            'rule' => array('url', TRUE),
            'required' => TRUE,
            'allowEmpty' => TRUE,
            'message' => 'Digite o endereço da pagína web'
        )
    );

}

?>
