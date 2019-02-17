<?php

class AlunonovosController extends AppController {

    public $name = "Alunonovos";
    public $components = array('Auth');

    public function beforeFilter() {

        parent::beforeFilter();
        // Para cadastrar usuarios do sistema precisso abrir este metodo

        $this->Auth->allow('add');

        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash('Administrador');
            // Estudantes podem somente fazer inscricao
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('add', 'edit', 'index', 'view');
            // $this->Session->setFlash('Estudante');
            // die();
            // Professores podem atualizar murais
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('edit', 'index', 'view');
            // $this->Session->setFlash('Professor');
            // No futuro os supervisores poderao lançar murals
        } elseif ($this->Session->read('id_categoria') === '4') {
            $this->Auth->allow('add', 'edit', 'index', 'view');
            // $this->Session->setFlash('Supervisor');
            // Todos
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/users/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

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

    public function add($id = NULL) {

        $this->set('registro', $id);
        // die("Alunonovo add: " . $id);
        /* Vejo se foi chamado desde cadastro
          $cadastro = $this->Session->read('cadastro');
          pr($cadastro);
          // die();
         */

        if ($this->Alunonovo->save($this->request->data)) {
            // die("Aluno novo save");
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
            $this->Session->setFlash("Cadastro realizado: " . $registro);
            // $this->redirect("/Inscricaos/solicitatermo/" . $registro);
	    // die(" Verificacao da rotina " . $registro);

    	    if ($inscricao_selecao_estagio) {
                // Volta para a pagina de inscricao
                // die("inscricao_seleciona_estagio");
                $this->redirect("/Inscricaos/inscricao/" . $registro);
            } elseif ($registro_termo) {
                // Volta para a pagina de termo de compromisso
                // die(" registro_termo " . $registro_termo);
                $this->redirect("/Inscricaos/termocompromisso/" . $registro_termo);
		die("Redireciona para concluir solicitacao de termo de compromisso");
            } elseif ($cadastro) {
                // die("cadastro");
                $this->Session->delete('cadastro');
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                $this->Session->write('menu_aluno', 'alunonovo');
                $this->Session->write('menu_id_aluno', $id_alunonovo);
                $this->redirect("/Alunonovos/view/" . $id_alunonovo);
            } else {
                // Mostra resultado da insercao
                /* Para poder colocar o link no menu superior */
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                // die(" else " . $id_alunonovo);
                $this->Session->write('menu_aluno', 'alunonovo');
                $this->Session->write('menu_id_aluno', $id_alunonovo);
                $this->Session->setFlash('Dados inseridos');
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                // die(" else " . $id_alunonovo);
  		$this->redirect("/Alunonovos/view/" . $id_alunonovo);
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

    public function edit($id = NULL) {

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

            $duplicada = $this->Alunonovo->findByRegistro($this->data['Alunonovo']['registro']);
            if ($duplicada)
                $this->Session->setFlash("O número de aluno já está cadastrado");

            if ($this->Alunonovo->save($this->data)) {

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

    public function view($id = NULL) {

        // echo "Aluno novo";
        $this->Session->read('numero');
        // Somente o próprio pode ver

        if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero'))) {
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

        $this->set('alunos', $aluno);
        $this->set('inscricoes', $inscricoes);
    }

    public function delete($id = NULL) {

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
