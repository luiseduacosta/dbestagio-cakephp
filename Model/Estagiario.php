<?php

class Estagiario extends AppModel {
    /* @var Aluno */
    /* @var Instituicao */
    /* @var Professor */
    /* @var Supervisor */
    /* @var Area */

    public $name = "Estagiario";
    public $useTable = "estagiarios";
    public $order = array("Estagiario.periodo" => "ASC");
    public $belongsTo = array(
        'Aluno' => array(
            'className' => 'Aluno',
            'foreignKey' => 'aluno_id',
            'joinTable' => 'alunos'
        ),
        'Estudante' => array(
            'className' => 'Alunonovo',
            'foreignKey' => false,
            'conditions' => 'Estagiario.registro = Estudante.registro',
            'joinTable' => 'alunosNovos'
        ),
        'Instituicao' => array(
            'className' => 'Instituicao',
            'foreignKey' => 'instituicao_id',
            'joinTable' => 'estagio'
        ),
        'Professor' => array(
            'className' => 'Professor',
            'foreignKey' => 'docente_id',
            'joinTable' => 'docentes',
            'fields' => array('id', 'nome', 'telefone', 'celular', 'email', 'cpf', 'siape', 'departamento')
        ),
        'Supervisor' => array(
            'className' => 'Supervisor',
            'foreignKey' => 'supervisor_id',
            'joinTable' => 'supervisores'
        ),
        'Area' => array(
            'className' => 'Area',
            'foreignKey' => 'id_area',
            'joinTable' => 'areas_estagio'
        )
    );
    public $validate = array(
        'instituicao_id' => array(
            'rule' => array('comparison', 'not equal', 0),
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Selecionar instituição de estágio'
        ),
        'periodo' => array(
            'rule' => '/^\d{4}-\d{1}$/i',
            'required' => TRUE,
            'allowEmpty' => TRUE,
            'on' => 'create',
            'message' => 'Digitar o periodo de estágio'
        ),
        'nivel' => array(
            'rule' => array('inList', array('1', '2', '3', '4', '9')),
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'on' => 'create',
            'message' => 'Selecionar nível de estágio. Para estágio não obrigatório selecionar 9'
        ),
        'turno' => array(
            'rule' => array('inList', array('D', 'N', 'I')),
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'on' => 'create',
            'message' => 'Selecionar turno de estágio'
        ),
        'tc_solicitacao' => array(
            'rule' => 'date',
            'required' => FALSE,
            'allowEmpty' => TRUE,
            'on' => 'create',
            'message' => 'Data da solicitação do Termo'
        ),
        'nota' => array(
            'rule' => array('range', 0, 10),
            'requiered' => TRUE,
            'allowEmpty' => TRUE,
            'on' => 'create',
            'message' => 'Valor entre 0 e 10 com as casas decimais separadas com um ponto'
        ),
        'ch' => array(
            'rule' => 'numeric',
            'requiered' => TRUE,
            'allowEmpty' => TRUE,
            'on' => 'create',
            'message' => 'Somente números inteiros'
        )
    );

    public function alunorfao() {

        // return($this->query('select Aluno.id, Aluno.registro, Aluno.nome, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.registro, Estagiario.nivel, Estagiario.periodo from alunos AS Aluno left join estagiarios AS Estagiario on Aluno.id = Estagiario.id_aluno where Estagiario.id IS NULL group by Aluno.nome order by Estagiario.registro + Estagiario.nivel'));
        return($this->query('select Aluno.id, Aluno.registro, Aluno.nome, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.registro, Estagiario.nivel, Estagiario.periodo from alunos AS Aluno left join estagiarios AS Estagiario on Aluno.id = Estagiario.aluno_id where Estagiario.id IS NULL order by Estagiario.registro + Estagiario.nivel'));
    }

    public function supervisor_aluno() {

        return ($this->query('select Aluno.id, Aluno.nome, Estagiario.registro, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.periodo, Supervisor.id, Supervisor.nome, Supervisor.cress, Supervisor.telefone, Supervisor.celular, Supervisor.email, Instituicao.id, Instituicao.instituicao from estagiarios AS Estagiario left join alunos AS Aluno on Estagiario.aluno_id = Aluno.id left join supervisores AS Supervisor on Estagiario.supervisor_id = Supervisor.id left join estagio as Instituicao on Estagiario.instituicao_id = Instituicao.id'));
    }

}

?>
