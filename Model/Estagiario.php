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
    public $actsAs = array('Containable');    
    public $belongsTo = array(
        'Estudante' => array(
            'className' => 'Estudante',
            'foreignKey' => 'estudante_id'
        ),
        'Aluno' => array(
            'className' => 'Aluno',
            'foreignKey' => 'aluno_id',
            'joinTable' => 'alunos'
        ),
        'Instituicaoestagio' => array(
            'className' => 'Instituicaoestagio',
            'foreignKey' => 'instituicaoestagio_id',
            'joinTable' => 'instituicaoestagios'
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
        'Areaestagio' => array(
            'className' => 'Areaestagio',
            'foreignKey' => 'areaestagio_id',
            'joinTable' => 'areaestagios'
        )
    );
    public $validate = array(
        'instituicaoestagio_id' => array(
            'rule' => array('comparison', 'not equal', 0),
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Selecionar instituição de estágio'
        ),
        'periodo' => array(
            'rule' => '/^\d{4}-\d{1}$/i',
            'required' => true,
            'allowEmpty' => true,
            'on' => 'create',
            'message' => 'Digitar o periodo de estágio'
        ),
        'nivel' => array(
            'rule' => array('inList', array('1', '2', '3', '4', '9')),
            'required' => true,
            'allowEmpty' => false,
            'on' => 'create',
            'message' => 'Selecionar nível de estágio. Para estágio não obrigatório selecionar 9.'
        ),
        'turno' => array(
            'rule' => array('inList', array('D', 'N', 'I')),
            'required' => true,
            'allowEmpty' => false,
            'on' => 'create',
            'message' => 'Selecionar turno de estágio. I para indeterminado.'
        ),
        'tc_solicitacao' => array(
            'rule' => 'date',
            'required' => false,
            'allowEmpty' => true,
            'on' => 'create',
            'message' => 'Data da solicitação do Termo'
        ),
        'nota' => array(
            'rule' => array('range', 0, 10),
            'requiered' => true,
            'allowEmpty' => true,
            'on' => 'create',
            'message' => 'Valor entre 0 e 10 com as casas decimais separadas com um ponto'
        ),
        'ch' => array(
            'rule' => 'numeric',
            'requiered' => true,
            'allowEmpty' => true,
            'on' => 'create',
            'message' => 'Somente números inteiros'
        )
    );

    public function alunorfao() {

        // return($this->query('select Aluno.id, Aluno.registro, Aluno.nome, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.registro, Estagiario.nivel, Estagiario.periodo from alunos AS Aluno left join estagiarios AS Estagiario on Aluno.id = Estagiario.aluno_id where Estagiario.id IS NULL group by Aluno.nome order by Estagiario.registro + Estagiario.nivel'));
        return($this->query('select Aluno.id, Aluno.registro, Aluno.nome, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.registro, Estagiario.nivel, Estagiario.periodo from alunos AS Aluno left join estagiarios AS Estagiario on Aluno.id = Estagiario.aluno_id where Estagiario.id IS NULL order by Aluno.nome'));
    }

    public function supervisor_aluno() {
        return ($this->query('select Aluno.id, Aluno.nome, Estagiario.registro, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.periodo, Supervisor.id, Supervisor.nome, Supervisor.cress, Supervisor.telefone, Supervisor.celular, Supervisor.email, Instituicaoestagio.id, Instituicaoestagio.instituicao from estagiarios AS Estagiario left join alunos AS Aluno on Estagiario.aluno_id = Aluno.id left join supervisores AS Supervisor on Estagiario.supervisor_id = Supervisor.id left join estagio as Instituicaoestagio on Estagiario.instituicaoestagio_id = Instituicaoestagio.id'));
    }

}
