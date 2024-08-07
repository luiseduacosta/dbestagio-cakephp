<?php

class Aluno extends AppModel {
    /*
     * @var Estagiario
     */

    public $name = 'Aluno';
    public $useTable = 'alunos';
    public $primaryKey = 'id';  // há outro campo id
    public $displayField = 'nome';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'aluno_id' 
        ),
    );
    
    public function beforeValidate($options = array()) {
        
        $this->data['Aluno']['email'] = strtolower($this->data['Aluno']['email']);
        $this->data['Aluno']['nome'] = ucwords(strtolower($this->data['Aluno']['nome']));
        $this->data['Aluno']['endereco'] = ucwords(strtolower($this->data['Aluno']['endereco']));
        $this->data['Aluno']['bairro'] = ucwords(strtolower($this->data['Aluno']['bairro']));
        // pr($this->data['User']['email']);
        return true;
        
    }

    public $validate = array(
        'nome' => array(
            'rule' => 'notBlank',
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
                'message' => 'Digite o número de CPF'
            ),
            'cpf2' => array(
                'rule' => 'cpf_verifica',
                'on' => 'create',
                'message' => 'CPF inválido: já cadastradao '
            )
        ),
        'identidade' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'on' => 'create',
            'message' => 'Digite o número da sua carteira de identidade'
        ),
        'orgao' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'on' => 'create',
            'message' => 'Digite o orgão expedidor da sua carteira de identidade'
        ),
        'endereco' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'on' => 'create',
            'message' => 'Digite seu endereço'
        ),
        'bairro' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'on' => 'create',
            'message' => 'Digite o seu bairro'
        ),
        'municipio' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'on' => 'create',
            'message' => 'Digite seu município'
        ),
        'cep' => array(
            'rule' => '/^\d{5}-\d{3}$/i',
            'required' => TRUE,
            'on' => 'create',
            'message' => 'Digite o número de CEP'
        )
    );

    public function registro_verifica($check) {

        $value = array_values($check);
        // pr($value);
        $valuefirst = $value[0];
        // pr($valuefirst);
        // die('valuefirst');
        
        if (strlen($valuefirst) < 9) {
            return FALSE;
        }

        if (!empty($valuefirst)) {
            // echo "Modelo - Consulta";
            $registro = $this->find('first', ['conditions' => ['Aluno.registro' => $valuefirst]]);
        }
        // pr($registro);
        // die('registro');

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
            // echo $msg;
            return FALSE;
        }

        if ($data_informada > $hoje) {
            $msg = "Data de nascimento maior que o dia de hoje";
            // echo $msg;
            return FALSE;
        }

        $diff = abs($hoje - $data_informada);
        $idade = floor($diff / (365 * 60 * 60 * 24));
        if ($idade < 17) {
            $msg = 'Menor de idade: ' . $idade;
            // echo $msg;
            return FALSE;
        }

        return TRUE;
    }

    public function email_verifica($check) {

        $cadastro_email = $check['email'];

        $emails = NULL;
        if (!empty($cadastro_email)) {
            $emails = $this->query('select email from  alunos as Aluno where email = ' . "'" . $cadastro_email . "'");
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
