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
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'id_instituicao',
            'joinTable' => 'estagiarios'
        ),
        'Mural' => array(
            'className' => 'Mural',
            'foreignKey' => 'id_estagio'
        ),
        'Visita' => array(
            'className' => 'Visita',
            'foreignKey' => 'estagio_id'
        )
    );
    public $belongsTo = array(
        'AreaInstituicao' => array(
            'className' => 'AreaInstituicao',
            'foreignKey' => 'area_instituicoes_id'
        )
    );
    public $hasAndBelongsToMany = array(
        'Supervisor' => array(
            'className' => 'Supervisor',
            'joinTable' => 'inst_super',
            'foreignKey' => 'id_instituicao',
            'associationForeignKey' => 'id_supervisor',
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
