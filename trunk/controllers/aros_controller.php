<?php

class ArosController extends AppController {

    var $name = 'Aros';

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->Acl->check($this->Session->read('user'), 'controllers', '*')) {
            $this->Auth->allowedActions = array('*');
            $this->Session->setFlash("Administrador");
        } else {
            $this->Session->setFlash("Não autorizado");
        }
    }
   
    function listausuarios() {
        
        $this->loadModel('User');
        $this->set('listausuarios', $this->User->find('all'));
        $this->set('listausuarios', $this->User->find('all', array('fields' => array('id', 'categoria', 'numero', 'email'), 'order' => 'id DESC')));
        // pr($this->User->find('all'));
        
    }

    function indexaros() {
        
        $this->loadModel('User');
        // pr($this->Aro->find('all'));
        $this->set('aros', $this->User->permissoes());
        
    }

    function viewaros($id = NULL) {
        
        if ($id) {
            // pr($this->User->permissoes());
            $this->loadModel('ArosAco');
            $usuario = $this->ArosAco->find('first', array(
                'conditions' => array('ArosAco.id=' . $id)
                    ));
            // pr($usuario);
             
            // Capturo a categoria de usuario
            $this->loadModel('Aro');
            $categoria = $this->Aro->find('first', array(
                'conditions' => array('Aro.id=' . $usuario['ArosAco']['aro_id'])
                    ));
            // pr($categoria['Aro']['alias']);

            // Capturo o objeto da acao do usuario
            $this->loadModel('Aco');
            $objeto = $this->Aco->find('first', array(
                'conditions' => array('Aco.id=' . $usuario['ArosAco']['aco_id'])
                    ));
            // pr($objeto['Aco']['alias']);

            $this->set('objeto', $objeto['Aco']['alias']);
            $this->set('categoria', $categoria['Aro']['alias']);
            $this->set('usuario', $usuario);
        }
    }

    function editaros($id = NULL) {
        
        if (empty($this->data)) {

            $this->loadModel('ArosAco');
            $usuario = $this->ArosAco->find('first', array(
                'conditions' => array('ArosAco.id=' . $id)
                    ));
            // pr($usuario);

            // Capturo a categoria de usuario
            $this->loadModel('Aro');
            $categoria = $this->Aro->find('first', array(
                'conditions' => array('Aro.id=' . $usuario['ArosAco']['aro_id'])
                    ));
            // pr($categoria['Aro']['alias']);
 
            // Capturo o objeto da acao do usuario
            $this->loadModel('Aco');
            $objeto = $this->Aco->find('first', array(
                'conditions' => array('Aco.id=' . $usuario['ArosAco']['aco_id'])
                    ));
            // pr($objeto['Aco']['alias']);

            $this->set('usuario', $usuario);
            $this->set('objeto', $objeto['Aco']['alias']);
            $this->set('categoria', $categoria['Aro']['alias']);
            
        } else {
            
            $this->loadModel('ArosAco');
            if ($this->ArosAco->save($this->data)) {
                $this->Session->setFlash("Atualizado");
                $this->redirect('/aros/viewaros/' . $this->data['ArosAco']['id']);
            }
            
        }
    }

}

?>
