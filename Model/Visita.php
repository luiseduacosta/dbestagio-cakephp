<?php

class Visita extends AppModel {
    /*
     * @var Estagiario
     */

    public $name = 'Visita';
    public $useTable = 'visita';
    public $primaryKey = 'id';
    public $displayField = 'data';
    public $belongsTo = array(
        'Instituicao' => array(
            'className' => 'Instituicao',
            'foreignKey' => 'estagio_id'
        )
    );
    public $validate = array(
        'motivo' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Digite o motivo da visita'
        ),
        'responsavel' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Digite quem fez a visita'
        ),
        'avaliacao' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Digite o resultado da visita'
        ),
        'data' => array(
            'rule' => 'date',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'on' => 'create',
            'message' => 'Digite a data da visita'
        ),
    );

}

?>
