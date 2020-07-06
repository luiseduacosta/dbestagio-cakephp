<?php

class Muralestagio extends AppModel {
    /*
     * @var Inscricao
     * @var Instituicao
     * @var Areaestagio
     * @var Professor
     */

    public $name = 'Muralestagio';
    public $useTable = 'muralestagios';
    public $primaryKey = 'id';
    public $displayField = 'instituicao';
    public $actsAs = array('Containable');    

    public $hasMany = array(
        'Inscricao' => array(
            'className' => 'Inscricao',
            'foreignKey' => 'mural_estagio_id'
        )
    );
    public $belongsTo = array(
        'Instituicao' => array(
            'className' => 'Instituicao',
            'foreignKey' => 'estagio_id'
        ),
        'Areaestagio' => array(
            'className' => 'Areaestagio',
            'foreignKey' => 'areaestagio_id'
        ),
        'Professor' => array(
            'className' => 'Professor',
            'foreignKey' => 'docente_id'
        ),
    );
    public $validate = array(
        'estagio_id' => array(
            'rule' => 'notBlank',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Escolha uma instituição'
        ),
        /*
          'instituicao' => array(
          'rule' => 'notBlank',
          'required' => TRUE,
          'allowEmpty' => FALSE,
          'message' => 'Instituição não pode ficar em branco'
          ),
         */
        'convenio' => array(
            'rule' => array('inList', array('0', '1')),
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Escolha uma das opções'
        ),
        'vagas' => array(
            'rule' => 'numeric',
            'maxLenght' => 3,
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Digite somente números (até 3 dígitos)'
        ),
        'final_de_semana' => array(
            'rule' => array('inList', array('0', '1', '2')),
            'required' => TRUE,
            'message' => 'Escolha uma das opções'
        ),
        'cargaHoraria' => array(
            'rule' => 'numeric',
            'maxLenght' => 2,
            'required' => TRUE,
            'message' => 'Digite somente números'
        ),
        'horario' => array(
            'rule' => array('inList', array('D', 'N', 'A')),
            'required' => TRUE,
            'message' => 'Escolha o turno da disciplina de OTP'
        ),
        /*
          'dataSelecao' => array(
          'rule' => 'date',
          'required' => TRUE,
          'allowEmpty' => TRUE,
          'message' => 'Data da prova de seleção'
          ),
         */
        'horarioSelecao' => array(
            'rule' => '/^\d{2}:\d{2}$/i',
            'maxLenght' => 5,
            'required' => TRUE,
            'allowEmpty' => TRUE,
            'message' => 'Formato inválido. O formato é 99:99'
        ),
        'formaSelecao' => array(
            'rule' => array('inList', array('0', '1', '2', '3')),
            'required' => FALSE,
            'message' => 'Escolher uma das opções'
        ),
        /*
          'dataInscricao' => array(
          'rule' => 'date',
          'required' => TRUE,
          'allowEmpty' => TRUE,
          'message' => 'Data de encerramento das inscrições'
          ),
         */
        'periodo' => array(
            'rule' => '/^\d{4}-\d{1}$/i',
            'maxLenght' => 6,
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Formato inválido'
        ),
        'email' => array(
            'rule' => 'email',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Digite o email para envio das inscrições'
        ),
        'datafax' => array(
            'rule' => 'date',
            'required' => FALSE,
            'allowEmpty' => TRUE,
            'message' => 'Data de envio do email com os inscritos'
        ),
    );

}

?>
