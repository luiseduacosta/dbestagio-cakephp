<?php

class ConfiguracaosController extends AppController {

    public $name = "Configuracaos";
    public $components = array('Auth');

    // var $scaffold;

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            $this->Session->setFlash(__("Administrador"), "flash_notification");
        } else {
            $this->Session->setFlash(__("Administração: Não autorizado"), "flash_notification");
        }
        // die(pr($this->Session->read('user')));
    }

    public function view($id = NULL) {

        $configuracao = $this->Configuracao->find('first');
        // pr($configuracao);

        $this->set('configuracao', $configuracao);
    }

    public function edit($id = NULL) {

        $this->Configuracao->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Configuracao->read();
        } else {
            if ($this->Configuracao->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash(__("Atualizado"), "flash_notification");
                $this->redirect('/Configuracaos/view/' . $id);
            }
        }
    }

}

?>
