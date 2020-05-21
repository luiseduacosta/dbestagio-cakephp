<?php

class Supervisor extends AppModel {
    /*
     * @var Estagiario
     * @var Instituicao
     */

    public $name = 'Supervisor';
    public $useTable = 'supervisores';
    public $primaryKey = 'id';
    public $displayField = 'nome';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'supervisor_id')
    );
    public $hasAndBelongsToMany = array(
        'Instituicao' => array(
            'className' => 'Instituicao',
            'joinTable' => 'instituicao_supervisor',
            'foreignKey' => 'supervisor_id',
            'associationForeignKey' => 'instituicao_id',
            'unique' => TRUE,
            'fields' => '',
            'order' => '',
        )
    );

    public function beforeValidate($options = array()) {

        $this->data['Supervisor']['nome'] = ucwords(strtolower($this->data['Supervisor']['nome']));
        $this->data['Supervisor']['email'] = strtolower($this->data['Supervisor']['email']);

        return true;
    }

    public $validate = array(
        'cress' => array(
            'cress1' => array(
                'rule' => 'numeric',
                'required' => TRUE,
                'allowEmpty' => TRUE,
                'on' => 'create',
                'message' => 'Digite somente números',
            ),
            'cress2' => array(
                'rule' => 'verifica_cress',
                'on' => 'create',
                'message' => 'CRESS já cadastrado',
            )
        ),
        'email' => array(
            'rule' => 'email',
            'required' => TRUE,
            'allowEmpty' => TRUE,
            'message' => 'Digite um email válido'
        ),
        'cpf' => array(
            'cpf1' => array(
                'rule' => '/^\d{9}-\d{2}$/i',
                'required' => TRUE,
                'allowEmpty' => TRUE,
                'on' => 'create',
                'message' => 'Digite o número de CPF no formato 999999999-99'
            ),
            'cpf2' => array(
                'rule' => 'cpf_verifica',
                'on' => 'create',
                'message' => 'CPF inválido: já cadastradao'
            )
        )
    );

    public function verifica_cress($check) {

        $value = array_values($check);
        $valor = $value[0];

        if (!empty($valor)) {
            // echo "Consulta";
            $cress = $this->find('first', array('conditions' => 'Supervisor.cress = ' . $valor));
        }
        // pr($cress);
        // die();
        if ($cress) {
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
            $cpf = $this->query('Select cpf from supervisores as Supervisor where cpf = ' . "'" . $value . "'" . ' limit 1');
        }
        // pr($cpf);
        // die();
        if ($cpf) {
            return FALSE;
        }

        return TRUE;
    }

}

?>
