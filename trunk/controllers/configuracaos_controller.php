<?php

class ConfiguracaosController extends AppController {

    var $name = "Configuracaos";

    // var $scaffold;

    function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Acl->check($this->Session->read('user'), 'controllers', '*')) {
            $this->Auth->allowedActions = array('*');
            $this->Session->setFlash("Administrador");
        } else {
            $this->Session->setFlash("Administração: Não autorizado");
        }
        // die(pr($this->Session->read('user')));
    }

    function view($id = NULL) {

        $configuracao = $this->Configuracao->find('first');
        // pr($configuracao);

        $this->set('configuracao', $configuracao);
    }

    function edit($id = NULL) {

        $this->Configuracao->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Configuracao->read();
        } else {
            if ($this->Configuracao->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Configuracaos/view/' . $id);
            }
        }
    }

}

?>
