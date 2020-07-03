<?php

class Estudante extends AppModel {

    public $name = 'Estudante';
    public $useTable = 'estudantes';
    public $primaryKey = 'id';
    public $displayField = 'nome';
    public $actsAs = array('Containable');    
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'estudante_id'
        ),
        'Inscricao' =>
        array(
            'className' => 'Inscricao',
            'foreignKey' => 'estudante_id'
        )
    );

    public function alunonovorfao() {

        // return($this->query("select Estudante.id, Estudante.registro, Estudante.nome, Estudante.celular, Estudante.email, Inscricao.id, Inscricao.aluno_id from alunosNovos AS Estudante left join muralinscricao AS Inscricao on Estudante.registro = Inscricao.aluno_id where Inscricao.aluno_id IS NULL group by Estudante.registro order by Estudante.nome"));
        return($this->query("select Estudante.id, Estudante.registro, Estudante.nome, Estudante.celular, Estudante.email, Inscricao.id, Inscricao.registro from estudantes AS Estudante left join muralinscricoes AS Inscricao on Estudante.registro = Inscricao.registro where Inscricao.estudante_id IS NULL order by Estudante.nome"));
    }

    public function beforeValidate($options = array()) {

        // pr($this->data);
        $this->data['Estudante']['email'] = strtolower($this->data['Estudante']['email']);
        $this->data['Estudante']['nome'] = ucwords(strtolower($this->data['Estudante']['nome']));
        $this->data['Estudante']['endereco'] = ucwords(strtolower($this->data['Estudante']['endereco']));
        $this->data['Estudante']['bairro'] = ucwords(strtolower($this->data['Estudante']['bairro']));
        // pr($this->data);
        // die();
        return true;
    }

    public $validate = array(
        'nome' => array(
            'rule' => 'notBlank',
            'allowEmpty' => false,
            'message' => 'Digite o nome completo'
        ),
        'registro' => array(
            'registro1' => array(
                'rule' => 'numeric',
                'required' => true,
                'allowEmpty' => false,
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
                'required' => true,
                'allowEmpty' => false,
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
                'required' => true,
                'allowEmpty' => false,
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
                'required' => true,
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
            'rule' => 'notBlank',
            'required' => true,
            'on' => 'create',
            'message' => 'Digite o número da sua carteira de identidade'
        ),
        'orgao' => array(
            'rule' => 'notBlank',
            'required' => true,
            'on' => 'create',
            'message' => 'Digite o orgão expedidor da sua carteira de identidade'
        ),
        'endereco' => array(
            'rule' => 'notBlank',
            'required' => true,
            'on' => 'create',
            'message' => 'Digite seu endereço'
        ),
        'bairro' => array(
            'rule' => 'notBlank',
            'required' => true,
            'on' => 'create',
            'message' => 'Digite o seu bairro'
        ),
        'municipio' => array(
            'rule' => 'notBlank',
            'required' => true,
            'on' => 'create',
            'message' => 'Digite seu município'
        ),
        'cep' => array(
            'rule' => '/^\d{5}-\d{3}$/i',
            'required' => true,
            'on' => 'create',
            'message' => 'Digite o número de CEP corretamente formatado'
        )
    );

    public function registro_verifica($check) {
        $values = array_values($check);
        $value = $values[0];

        if (strlen($value) < 9) {
            return false;
        }

        if ($value) {
            // echo "Modelo - Consulta tabela Estudantes ";
            $registro = $this->find('first', array('conditions' => 'Estudante.registro = ' . $value));
        }

        /*
         * Não precisa fazer esta consulta
         * 
          if ($value) {
          // echo "Modelo - Consulta tabela alunos ";
          $registro = $this->query('select registro from alunos as Aluno where registro = ' . $value);
          }
         */
        // echo "Registro: " . $registro[0];
        // die();

        if ($registro) {
            return false;
        }

        return true;
    }

    public function nascimento_verifica($check) {
        $hoje = strtotime(date('Y-m-d'));
        $data_informada = strtotime($check['nascimento']);

        if ($data_informada == $hoje) {
            $msg = "Data de hoje";
            echo $msg;
            return false;
        }

        if ($data_informada > $hoje) {
            $msg = "Data de nascimento maior que o dia de hoje";
            echo $msg;
            return false;
        }

        $diff = abs($hoje - $data_informada);
        $idade = floor($diff / (365 * 60 * 60 * 24));
        if ($idade < 17) {
            $msg = 'Menor de idade: ' . $idade;
            echo $msg;
            return false;
        }

        return true;
    }

    public function email_verifica($check) {
        $cadastro_email = $check['email'];

        $emails = null;
        if (!empty($cadastro_email)) {
            $emails = $this->query('select email from estudantes as Estudante where email = ' . "'" . $cadastro_email . "'");
        }

        if ($emails) {
            return false;
        }

        return true;
    }

    public function cpf_verifica($check) {
        $value = null;
        $value = array_values($check);
        $value = $value[0];
        // pr($value);

        $cpf = null;
        if (!empty($value)) {
            $cpf = $this->query('select cpf from estudantes as Estudante where cpf = ' . "'" . $value . "'" . ' limit 1');
        }

        if ($cpf) {
            return false;
        }

        return true;
    }

}
