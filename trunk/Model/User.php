<?php

class User extends AppModel {
    /*
     * @var Role
     * @var Aro
     */

    public $name = 'User';
    public $useTable = 'users';
    public $displayField = 'email';
    public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
            'foreignKey' => 'categoria',
            'joinTable' => 'roles'
        ),
        'Aro' => array(
            'className' => 'Aro',
            'foreignKey' => FALSE,
            'conditions' => 'User.id=Aro.foreign_key',
            'joinTable' => 'aros'
        )
    );

    /*
      var $actsAs = array('Acl' => array('type' => 'requester'));
     */
    public $validate = array(
        'categoria' => array(
            'rule' => array('inList', array('1', '2', '3', '4')),
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

    public function permissoes() {

        return ($this->query("SELECT aros_acos.id, aros.alias, acos.alias, _create, _read, _update, _delete FROM `aros_acos` join aros on aros_acos.aro_id = aros.id join acos on aros_acos.aco_id = acos.id ORDER BY `aros`.`alias` ASC"));
    }

    function beforesave() {
        if ($this->data['User']['password']) {
            $this->request->data['User']['password'] = SHA1($this->data['User']['password']);
        }
        return true;
    }

    /*
      function parentNode() {
      if (!$this->id && empty($this->data)) {
      return null;
      }
      if (isset($this->data['User']['categoria'])) {
      $groupId = $this->data['User']['categoria'];
      } else {
      $groupId = $this->field('categoria');
      }
      if (!$groupId) {
      return null;
      } else {
      // pr($groupId);
      return array('Role' => array('id' => $groupId));
      }
      }
     */
}

?>
