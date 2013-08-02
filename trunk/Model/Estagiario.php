<?php

class Estagiario extends AppModel {

	/* @var Aluno */
	/* @var Instituicao */
	/* @var Professor */
	/* @var Supervisor */
	/* @var Area */

	public $name = "Estagiario";
	public $useTable = "estagiarios";
	public $order = array("Aluno.nome" => "ASC", "Estagiario.periodo" => "ASC");

	public $belongsTo = array(
			'Aluno' => array(
					'className' => 'Aluno',
					'foreignKey' => 'id_aluno',
					'joinTable' => 'alunos'
			),
			'Instituicao' => array(
					'className' => 'Instituicao',
					'foreignKey' => 'id_instituicao',
					'joinTable' => 'estagio'
			),
			'Professor' => array(
					'className' => 'Professor',
					'foreignKey' => 'id_professor',
					'joinTable' => 'professores',
					'fields' => array('id', 'nome', 'telefone', 'celular', 'email', 'cpf', 'siape', 'departamento')
			),
			'Supervisor' => array(
					'className' => 'Supervisor',
					'foreignKey' => 'id_supervisor',
					'joinTable' => 'supervisores'
			),
			'Area' => array(
					'className' => 'Area',
					'foreignKey' => 'id_area',
					'joinTable' => 'areas_estagio'
			)
	);

	public $validate = array(

			'id_instituicao' => array(
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
					'rule' => array('inList', array('1', '2', '3', '4')),
					'required' => TRUE,
					'allowEmpty' => FALSE,
					'on' => 'create',
					'message' => 'Selecionar nível de estágio'
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

		return($this->query('select Aluno.id, Aluno.registro, Aluno.nome, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.registro, Estagiario.nivel, Estagiario.periodo from alunos AS Aluno left join estagiarios AS Estagiario on Aluno.id = Estagiario.id_aluno where Estagiario.id IS NULL group by Aluno.nome order by Estagiario.registro + Estagiario.nivel'));

	}

	public function supervisor_aluno() {

		return ($this->query('select Aluno.id, Aluno.nome, Estagiario.registro, Aluno.celular, Aluno.email, Estagiario.id, Estagiario.periodo, Supervisor.id, Supervisor.nome, Supervisor.cress, Supervisor.telefone, Supervisor.celular, Supervisor.email, Instituicao.id, Instituicao.instituicao from estagiarios AS Estagiario left join alunos AS Aluno on Estagiario.id_aluno = Aluno.id left join supervisores AS Supervisor on Estagiario.id_supervisor = Supervisor.id left join estagio as Instituicao on Estagiario.id_instituicao = Instituicao.id'));

	}
}

?>
