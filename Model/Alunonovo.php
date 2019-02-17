<?php

class Alunonovo extends AppModel {

	public $name = 'Alunonovo';
	public $useTable = 'alunosNovos';
	public $primaryKey = 'id';
	public $displayField = 'nome';

	public function alunonovorfao () {

		// return($this->query("select Alunonovo.id, Alunonovo.registro, Alunonovo.nome, Alunonovo.celular, Alunonovo.email, Inscricao.id, Inscricao.id_aluno from alunosNovos AS Alunonovo left join mural_inscricao AS Inscricao on Alunonovo.registro = Inscricao.id_aluno where Inscricao.id_aluno IS NULL group by Alunonovo.registro order by Alunonovo.nome"));
		return($this->query("select Alunonovo.id, Alunonovo.registro, Alunonovo.nome, Alunonovo.celular, Alunonovo.email, Inscricao.id, Inscricao.id_aluno from alunosNovos AS Alunonovo left join mural_inscricao AS Inscricao on Alunonovo.registro = Inscricao.id_aluno where Inscricao.id_aluno IS NULL order by Alunonovo.nome"));
	}

	/*
	 var $hasMany = array(
	 		'Inscricao' => array(
	 				'className' => 'Inscricao',
	 				'foreignKey' => FALSE,
	 				'conditions' => 'Alunonovo.registro = Inscricao.id_aluno'
	 		));
	*/

	public $validate = array(
			'nome' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => FALSE,
					'message' => 'Digite o nome completo'
			),
			'registro' => array(
					'registro1' => array(
							'rule' => 'numeric',
							'required' => TRUE,
							'allowEmpty' => FALSE,
							'message' => 'Digite o número de DRE'
					),
					'registro2' => array(
							'rule' => array('between', 9, 9),
							'on' => 'create',
							'message' => 'Registro inválido'
					),

					'registro3' => array(
							'rule' => 'registro_verifica',
							'on' => 'create',
							'message' => 'Número de DRE inválido'
					)

			),
			'nascimento' => array(
					'nascimento1' => array(
							'rule' => 'date',
							'required' => TRUE,
							'allowEmpty' => FALSE,
							'on' => 'create',
							'message' => 'Digite a data de nascimento'
					),
					'nascimento2' => array(
							'rule' => 'nascimento_verifica',
							'on' => 'create',
							'message' => 'Data nascimento inválida'
					)
			),
			'email' => array(
					'email1' => array(
							'rule' => 'email',
							'required' => TRUE,
							'allowEmpty' => FALSE,
							'on' => 'create',
							'message' => 'Digite o seu email'
					),
					'email2' => array(
							'rule' => 'email_verifica',
							'on' => 'create',
							'message' => 'Email inválido: já cadastrado'
					)
			),
			'cpf' => array(
					'cpf1' => array(
							'rule' => '/^\d{9}-\d{2}$/i',
							'required' => TRUE,
							'on' => 'create',
							'message' => 'Digite o número de CPF corretamente formatado'
					),
					'cpf2' => array(
							'rule' => 'cpf_verifica',
							'on' => 'create',
							'message' => 'CPF inválido: já cadastradao '
					)
			),
			'identidade' => array(
					'rule' => 'notEmpty',
					'required' => TRUE,
					'on' => 'create',
					'message' => 'Digite o número da sua carteira de identidade'
			),
			'orgao' => array(
					'rule' => 'notEmpty',
					'required' => TRUE,
					'on' => 'create',
					'message' => 'Digite o orgão expedidor da sua carteira de identidade'
			),
			'endereco' => array(
					'rule' => 'notEmpty',
					'required' => TRUE,
					'on' => 'create',
					'message' => 'Digite seu endereço'
			),
			'bairro' => array(
					'rule' => 'notEmpty',
					'required' => TRUE,
					'on' => 'create',
					'message' => 'Digite o seu bairro'
			),
			'municipio' => array(
					'rule' => 'notEmpty',
					'required' => TRUE,
					'on' => 'create',
					'message' => 'Digite seu município'
			),
			'cep' => array(
					'rule' => '/^\d{5}-\d{3}$/i',
					'required' => TRUE,
					'on' => 'create',
					'message' => 'Digite o número de CEP corretamente formatado'
			)
	);

	public function registro_verifica($check) {

		$value = array_values($check);
		$value = $value[0];

		if (strlen($value) < 9) {
			return FALSE;
		}

		if ($value) {
			// echo "Modelo - Consulta tabela alunosNovos ";
			$registro = $this->find('first', array('conditions' => 'Alunonovo.registro = ' . $value));
		}

		if ($value) {
			// echo "Modelo - Consulta tabela alunos ";
			$registro = $this->query('select registro from alunos as Aluno where registro = ' . $value);
		}

		// echo "Registro: " . $registro[0];
		// die();

		if ($registro) {
			return FALSE;
		}

		return TRUE;
	}

	public function nascimento_verifica($check) {

		$hoje = strtotime(date('Y-m-d'));
		$data_informada = strtotime($check['nascimento']);

		if ($data_informada == $hoje) {
			$msg = "Data de hoje";
			echo $msg;
			return FALSE;
		}

		if ($data_informada > $hoje) {
			$msg = "Data de nascimento maior que o dia de hoje";
			echo $msg;
			return FALSE;
		}

		$diff = abs($hoje - $data_informada);
		$idade = floor($diff / (365 * 60 * 60 * 24));
		if ($idade < 17) {
			$msg = 'Menor de idade: ' . $idade;
			echo $msg;
			return FALSE;
		}

		return TRUE;
	}

	public function email_verifica($check) {

		$cadastro_email = $check['email'];

		$emails = NULL;
		if (!empty($cadastro_email)) {
			$emails = $this->query('select email from alunos as Aluno where email = ' . "'" . $cadastro_email . "'");
		}

		if ($emails) {
			return FALSE;
		}

		return TRUE;
	}

	public function cpf_verifica($check) {

		$value = NULL;
		$value = array_values($check);
		$value = $value[0];
		// pr($value);

		$cpf = NULL;
		if (!empty($value)) {
			$cpf = $this->query('select cpf from alunos as Aluno where cpf = ' . "'" . $value . "'" . ' limit 1');
		}

		if ($cpf) {
			return FALSE;
		}

		return TRUE;
	}

}

?>
