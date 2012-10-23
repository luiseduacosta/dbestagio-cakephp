<?php

class ArosController extends AppController {

    public $name = 'Aros';

    public function beforeFilter() {
        parent::beforeFilter();
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
        } else {
            $this->Session->setFlash("Aros: Não autorizado");
        }
    }

    public function listausuarios() {

        $this->loadModel('User');
        // $this->set('listausuarios', $this->Acl->Aro->find('all'));
        $usuarios = $this->User->find('all');

        $this->loadModel('Aluno');
        $this->loadModel('Alunonovo');
        $this->loadModel('Professor');
        $this->loadModel('Supervisor');
        $i = 1;
        foreach ($usuarios as $cadausuario) {
            // pr($cadausuario);
            $estudante = NULL;
            $nome = NULL;
            $aluno_id = NULL;
            $aluno_tipo = NULL;
            switch ($cadausuario['User']['categoria']) {
                case 1:
                    $nome = 'Administrador';
                    $aluno_tipo = 5;
                    break;
                case 2:
                    // Busco entre os estudantes em estágio
                    $estudante = $this->Aluno->find('first', array(
                        'conditions' => 'Aluno.registro=' . $cadausuario['User']['numero']));
                    $nome = $estudante['Aluno']['nome'];
                    $aluno_id = $estudante['Aluno']['id'];
                    $aluno_tipo = 0; // Aluno estagiario
                    // Se não está entre os estudantes em estágio busco entre os novos
                    // $estudantenovo = NULL;
                    if (empty($estudante)) {
                        $estudantenovo = $this->Alunonovo->find('first', array(
                            'conditions' => 'Alunonovo.registro=' . $cadausuario['User']['numero']));
                        $nome = $estudantenovo['Alunonovo']['nome'];
                        $aluno_id = $estudantenovo['Alunonovo']['id'];
                        $aluno_tipo = 1; // Aluno novo
                    }

                    // Se não está entre os novos então é um usuario nao cadastrado
                    if ((empty($estudante)) & (empty($estudantenovo))) {
                        $nome = "Usuário estudante sem cadastro";
                        $aluno_id = NULL;
                        $aluno_tipo = 2; // Usuario estudante nao cadastrado
                    }
                    break;
                case 3:
                    $professor = $this->Professor->find('first', array(
                        'conditions' => 'Professor.siape=' . $cadausuario['User']['numero']));
                    if ($professor) {
                        $nome = $professor['Professor']['nome'];
                    } else {
                        $nome = 'Professor não cadastrado!!';
                    }
                    $aluno_id = $professor['Professor']['id'];
                    $aluno_tipo = 3;
                    break;
                case 4:
                    $supervisor = $this->Supervisor->find('first', array(
                        'conditions' => 'Supervisor.cress=' . $cadausuario['User']['numero']));
                    if ($supervisor) {
                        $nome = $supervisor['Supervisor']['nome'];
                    } else {
                        $nome = "Supervisor não cadastrado!!";
                    }
                    $aluno_id = $supervisor['Supervisor']['id'];
                    $aluno_tipo = 4;
                    break;
                default:
                    $nome = 'Sem categoria!!';
                    $aluno_id = NULL;
                    $aluno_tipo = 5;
                    break;
            }
            // echo "Indice " . $i . "<br>";
            $todos[$i]['id'] = $cadausuario['User']['id'];
            $todos[$i]['aluno_tipo'] = $aluno_tipo;
            $todos[$i]['aluno_id'] = $aluno_id;
            $todos[$i]['numero'] = $cadausuario['User']['numero'];
            $todos[$i]['nome'] = $nome;
            $todos[$i]['email'] = $cadausuario['User']['email'];
            $todos[$i]['categoria'] = $cadausuario['Role']['categoria'];
            $i++;
        }
        // pr($todos);
        $this->set('listausuarios', $todos);
        // $this->set('listausuarios', $this->User->find('all'));
    }

    public function indexaros() {

        $this->loadModel('User');
        $this->set('aros', $this->User->permissoes());
    }

    public function viewaros($id = NULL) {

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

    public function editaros($id = NULL) {

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

    public function deletearos($id = NULL) {

        $this->loadModel('User');

        if ($id == 1) {
            $this->Session->setFlash("Administrador não pode ser excluído");
            $this->redirect(array('action' => 'listausuarios'));
            die("Error: usuário administrador não pode ser excluido");
            break;
        }
        if ($this->User->delete($id)) {
            // Delete Associated Aro
            $AroData = $this->Aro->findByForeignKey($id);
            print_r($AroData);
            $this->Aro->delete($AroData['Aro']['id']);
            $this->Session->setFlash(__('User deleted', true));
            // $this->Session->setFlash(__('User deleted', true), 'flash');
            $this->redirect(array('action' => 'listausuarios'));
        } else {
            print_r($id);
            $this->redirect(array('action' => 'listausuarios'));
            $this->Session->setFlash(__('Usuário não foi excluído', true), 'flash');
            die("Error: usuário não foi excluido");
        }
    }

}

?>
