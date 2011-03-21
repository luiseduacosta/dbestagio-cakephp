<?php

class AlunonovosController extends AppController {

    var $name = "Alunonovos";

    // var $scaffold;

    function beforeFilter() {

        parent::beforeFilter();
        // Para cadastrar usuarios do sistema precisso abrir este metodo
        $this->Auth->allowedActions = array('add');
        // Admin
        if ($this->Acl->check($this->Session->read('user'), 'controllers', '*')) {
            $this->Auth->allowedActions = array('*');
            $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Acl->check($this->Session->read('user'), 'alunonovos', 'create')) {
            $this->Auth->allowedActions = array('add', 'index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit');
            $this->Session->setFlash("Estudante");
            // Professores e Supervisores
        } elseif ($this->Acl->check($this->Session->read('user'), 'alunonovos', 'read')) {
            $this->Auth->allowedActions = array('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email');
            $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
        }
        // die(pr($this->Session->read('user')));
    }

    function index($id = NULL) {

        $alunonovo = $this->Alunonovo->find('all', array('order' => 'Alunonovo.nome'));
        /*
          pr($alunonovo['Alunonovo']);
          pr($alunonovo['Mural']);
         */
        $this->set('alunonovo', $alunonovo);
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso
     */

    function add($id = NULL) {

        $this->set('registro', $id);

        if ($this->Alunonovo->save($this->data)) {

            // Capturo o id da instituicao (se foi chamada desde inscriacao add)
            $inscricao_selecao_estagio = $this->Session->read('id_instituicao');
            // Ainda nao posso apagar
            // $this->Session->delete('id_instituicao');
            // Capturo se foi chamado desde a solicitacao do termo
            $registro_termo = $this->Session->read('termo');
            // Acho que posso apagar aqui porque nao vai ser chamado novamente
            $this->Session->delete('termo');

            // Vejo se foi chamado desde cadastro
            $cadastro = $this->Session->read('cadastro');

            $registro = $this->data['Alunonovo']['registro'];
            $this->Session->setFlash("Cadastro realizado");

            if ($inscricao_selecao_estagio) {
                // Volta para a pagina de inscricao
                $this->redirect('/Inscricaos/inscricao/' . $registro);
            } elseif ($registro_termo) {
                // Volta para a pagina de termo de compromisso
                $this->redirect('/Inscricaos/termocompromisso/' . $registro_termo);
            } elseif ($cadastro) {
                $this->redirec('/Users/cadastro/' . $cadastro);
            } else {
                // Mostra resultado da insercao
                $this->Session->setFlash('Dados inseridos');
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                $this->redirect('/Alunonovos/view/' . $id_alunonovo);
            }
        }
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso
     */

    /*
     * id eh o id do alunonovo
     */

    function edit($id = NULL) {

        // Somente o próprio pode editar
        if ($this->Session->read('numero')) {
            $verifica = $this->Alunonovo->findByRegistro($this->Session->read('numero'));
            if ($id != $verifica['Alunonovo']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Murals/index");
                die("Não autorizado");
            }
        }

        $this->Alunonovo->id = $id;
        // pr($id);
        if (empty($this->data)) {

            $this->data = $this->Alunonovo->read();

        } else {

            if ($this->Alunonovo->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");

                // Capturo o id da instituicao (se foi chamada desde inscriacao add)
                $inscricao_selecao_estagio = $this->Session->read('id_instituicao');
                // Ainda nao posso apagar
                // $this->Session->delete('id_instituicao');
                // Capturo se foi chamado desde a solicitacao do termo
                $registro_termo = $this->Session->read('termo');
                $this->Session->delete('termo');
                if ($inscricao_selecao_estagio) {
                    // Faz inscricao para selecao de estagio
                    $this->Session->setFlash("Inscricao para selecao de estagio");
                    $this->redirect('/Inscricaos/inscricao/' . $this->data['Alunonovo']['registro']);
                } elseif (!empty($registro_termo)) {
                    // Solicita termo de compromisso
                    $this->Session->setFlash("Solicitacao de termo de compromisso");
                    // $this->redirect('/Inscricaos/termocompromisso/' . $registro_termo);
                } else {
                    // Simplesmente atualiza e mostra o resultado
                    $this->redirect('/Alunonovos/view/' . $id);
                }
            }
        }
    }

    function view($id = NULL) {

        // echo "Aluno novo";
        // die(pr($this->Session->read('numero')));
        // Somente o próprio pode ver
        if ($this->Session->read('numero')) {
            $verifica = $this->Alunonovo->findByRegistro($this->Session->read('numero'));
            // pr($this->Session->read('numero'));

            if ($id != $verifica['Alunonovo']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Murals/index");
                die("Não autorizado");
            }
        }

        $aluno = $this->Alunonovo->findById($id);
        // pr($aluno);

        // Onde fizeram inscricoes
        $this->loadModel('Inscricao');
        $inscricoes = $this->Inscricao->findAllByIdAluno($aluno['Alunonovo']['registro']);
        // pr($inscricoes);

        $this->set('alunos', $aluno);
        $this->set('inscricoes', $inscricoes);

    }

    function delete($id = NULL) {

        // Pego o numero de registro
        $registro = $this->Alunonovo->findById($id, array('fields' => 'registro'));
        // Pego as inscricoes realizadas

        $this->loadModel('Inscricao');
        $inscricao = $this->Inscricao->find('all', array(
                    'conditions' => array('Inscricao.id_aluno' => $registro['Alunonovo']['registro']),
                    'fields' => 'id'));
        // pr($inscricao);
        // die();

        if ($inscricao) {
            foreach ($inscricao as $c_inscricao) {
                // pr($c_inscricao['Inscricao']['id']);
                // die();
                $this->Inscricao->delete($c_inscricao['Inscricao']['id']);
            }
        }

        $this->Alunonovo->delete($id);

        $this->Session->setFlash("Registro excluído (junto com as inscrições)");
        $this->redirect("/Inscricaos/index/");
    }

}

?>
