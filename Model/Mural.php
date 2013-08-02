<?php

class Mural extends AppModel {
    /*
     * @var Inscricao
     * @var Instituicao
     * @var Area
     * @var Professor
     */

    public $name = 'Mural';
    public $useTable = 'mural_estagio';
    public $primaryKey = 'id';
    public $displayField = 'instituicao';

    public $hasMany = array(
        'Inscricao' => array(
            'className' => 'Inscricao',
            'foreignKey' => 'id_instituicao'
        )
    );
    public $belongsTo = array(
        'Instituicao' => array(
            'className' => 'Instituicao',
            'foreignKey' => 'id_estagio'
        ),
        'Area' => array(
            'className' => 'Area',
            'foreignKey' => 'id_area'
        ),
        'Professor' => array(
            'className' => 'Professor',
            'foreignKey' => 'id_professor'
        ),
    );
    public $validate = array(
        'id_estagio' => array(
            'rule' => 'notEmpty',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Escolha uma instituição'
        ),
        /*
          'instituicao' => array(
          'rule' => 'notEmpty',
          'required' => TRUE,
          'allowEmpty' => FALSE,
          'message' => 'Instituição não pode ficar em branco'
          ),
         */
        'convenio' => array(
            'rule' => array('inList', array(0, 1)),
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
