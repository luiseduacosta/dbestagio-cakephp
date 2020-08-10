<?php

class Instituicaoestagio extends AppModel {
    /* @var Estagiario */
    /* @var Mural */
    /* @var Area */
    /* @var Supervisor */

    public $name = "Instituicaoestagio";
    public $useTable = "instituicaoestagios";
    public $primaryKey = "id";
    public $displayField = "instituicao";
    public $actsAs = array('Containable');
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'instituicaoestagio_id',
            'joinTable' => 'estagiarios'
        ),
        'Mural' => array(
            'className' => 'Muralestagio',
            'foreignKey' => 'instituicaoestagio_id'
        ),
        'Visita' => array(
            'className' => 'Visita',
            'foreignKey' => 'instituicaoestagio_id'
        )
    );
    public $belongsTo = array(
        'Areainstituicao' => array(
            'className' => 'Areainstituicao',
            'foreignKey' => 'areainstituicao_id'
        )
    );
    public $hasAndBelongsToMany = array(
        'Supervisor' => array(
            'className' => 'Supervisor',
            'joinTable' => 'instituicaoestagio_supervisor',
            'foreignKey' => 'instituicaoestagio_id',
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
