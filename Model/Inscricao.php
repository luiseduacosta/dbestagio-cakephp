<?php

class Inscricao extends AppModel {
    /* @var Mural */
    /* @var Aluno */
    /* @var Alunonovo */

    public $name = 'Inscricao';
    public $useTable = 'mural_inscricao';
    public $primaryKey = 'id';
    public $belongsTo = array(
        'Mural' => array(
            'className' => 'Mural',
            'foreignKey' => 'mural_estagio_id',
        ),
        'Aluno' => array(
            'className' => 'Aluno',
            'foreignKey' => FALSE,
            'conditions' => 'Inscricao.aluno_id = Aluno.registro'
        ),
        'Alunonovo' => array(
            'className' => 'Alunonovo',
            'foreignKey' => FALSE,
            'conditions' => 'Inscricao.aluno_id = Alunonovo.registro'
        ),
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => FALSE,
            'conditions' => array('Inscricao.aluno_id = Estagiario.registro', 'Inscricao.periodo = Estagiario.periodo')
        )
    );

}

?>
