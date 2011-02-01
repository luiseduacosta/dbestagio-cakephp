<?php

class User extends AppModel {

    var $name = 'User';
    var $useTable = 'users';
    var $displayField = 'email';
    var $validate = array(

        'categoria' => array(
            'rule' => array('inList', array('1', '2', '3')),
            'message' => 'Selecione uma categoria de usuário',
            'required' => TRUE,
            'allowEmpty' => FALSE
        ),

        'numero' => array(
            'rule' => 'numeric',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Número: Digite somente números'
        ),

        'email' => array(
            'email1' => array(
                'rule' => 'email',
                'required' => TRUE,
                'allowEmpty' => FALSE,
                'message' => 'Email: Digite um email válido'
            ),
            'email2' => array(
                'rule' => 'isUnique',
                'on' => 'create',
                'message' => 'Email: Email já está cadastrado'
            )
        ),

        'password' => array(
            'rule' => 'notEmpty',
            'message' => 'Senha: Digite uma senha',
            'required' => TRUE,
            'allowEmpty' => FALSE
        )

    );

}

?>
