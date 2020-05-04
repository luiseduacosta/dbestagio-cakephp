<?php

class EstudantesController extends AppController {

    public $name = "Estudantes";
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
            $this->redirect('/Userestagios/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $alunonovo = $this->Estudante->find('all', array('order' => 'Estudante.nome'));
        /*
          pr($alunonovo['Estudante']);
          pr($alunonovo['Muralestagio']);
         */
        $this->set('alunonovo', $alunonovo);
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso
     */

    public function add($id = null) {

        $this->set('registro', $id);
        // die("Alunonovo add: " . $id);
        /* Vejo se foi chamado desde cadastro
          $cadastro = $this->Session->read('cadastro');
          pr($cadastro);
          // die();
         */

        if ($this->Estudante->save($this->data)) {
            // die("Aluno novo save");
            // Capturo o id da instituicao (se foi chamada desde inscriacao add)
            $inscricao_selecao_estagio = $this->Session->read('instituicao_id');
            // Ainda nao posso apagar
            // $this->Session->delete('instituicao_id');
            // Capturo se foi chamado desde a solicitacao do termo
            $registro_termo = $this->Session->read('termo');
            // Acho que posso apagar aqui porque nao vai ser chamado novamente
            $this->Session->delete('termo');

            // Vejo se foi chamado desde cadastro
            $cadastro = $this->Session->read('cadastro');

            $registro = $this->data['Estudante']['registro'];
            $this->Session->setFlash(__("Cadastro realizado: " . $registro));
            // $this->redirect("/Inscricoes/solicitatermo/" . $registro);
            // die(" Verificacao da rotina " . $registro);

            if ($inscricao_selecao_estagio) {
                // Volta para a pagina de inscricao
                // die("inscricao_seleciona_estagio");
                $this->redirect("/Inscricoes/inscricao/" . $registro);
            } elseif ($registro_termo) {
                // Volta para a pagina de termo de compromisso
                // die(" registro_termo " . $registro_termo);
                $this->redirect("/Inscricoes/termocompromisso/" . $registro_termo);
                die("Redireciona para concluir solicitacao de termo de compromisso");
            } elseif ($cadastro) {
                // die("cadastro");
                $this->Session->delete('cadastro');
                $id_alunonovo = $this->Estudante->getLastInsertId();
                $this->Session->write('menu_aluno', 'alunonovo');
                $this->Session->write('menu_id_aluno', $id_alunonovo);
                $this->redirect("/Estudantes/view/" . $id_alunonovo);
            } else {
                // Mostra resultado da insercao
                $this->Session->write('menu_aluno', 'alunonovo');
                $this->Session->write('menu_id_aluno', $id_alunonovo);
                $this->Session->setFlash('Dados inseridos');
                $id_alunonovo = $this->Estudante->getLastInsertId();
                // die(" else " . $id_alunonovo);
                $this->redirect("/Estudantes/view/" . $id_alunonovo);
            }
        }
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso
     * id eh o id do alunonovo
     */
    public function edit($id = null) {

        // Somente o próprio pode editar
        if ($this->Session->read('numero')) {
            $verifica = $this->Estudante->findByRegistro($this->Session->read('numero'));
            if ($id != $verifica['Estudante']['id']) {
                $this->Session->setFlash(__("Acesso não autorizado"));
                $this->redirect("/Murals/index");
                die("Não autorizado");
            }
        }

        $this->Estudante->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Estudanate->read();
        } else {
            $duplicada = $this->Estudante->findByRegistro($this->data['Estudante']['registro']);
            if ($duplicada) {
                $this->Session->setFlash("O número de aluno já está cadastrado");
            }

            if ($this->Estudante->save($this->data)) {
                $this->Session->setFlash("Atualizado");

                // Capturo o id da instituicao (se foi chamada desde inscriacao add)
                $inscricao_selecao_estagio = $this->Session->read('instituicao_id');
                // Ainda nao posso apagar
                // $this->Session->delete('instituicao_id');
                // Capturo se foi chamado desde a solicitacao do termo
                $registro_termo = $this->Session->read('termo');
                $this->Session->delete('termo');
                if ($inscricao_selecao_estagio) {
                    // Faz inscricao para selecao de estagio
                    $this->Session->setFlash("Inscricao para selecao de estagio");
                    $this->redirect('/Inscricoes/inscricao/' . $this->data['Estudante']['registro']);
                } elseif (!empty($registro_termo)) {
                    // Solicita termo de compromisso
                    $this->Session->setFlash("Solicitacao de termo de compromisso");
                    // $this->redirect('/Inscricoes/termocompromisso/' . $registro_termo);
                } else {
                    // Simplesmente atualiza e mostra o resultado
                    $this->redirect('/Estudantes/view/' . $id);
                }
            }
        }
    }

    public function view($id = null) {

        // echo "Aluno novo";
        $this->Session->read('numero');
        // Somente o próprio pode ver
        // die();
        if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero'))) {
            $verifica = $this->Estudante->findByRegistro($this->Session->read('numero'));
            // pr($this->Session->read('numero'));

            if ($id != $verifica['Estudante']['id']) {
                $this->Session->setFlash("Estudante");
                // $this->redirect("/Muralestagios/index");
                // die("Não autorizado");
            }
        }
        // pr($id);
        // die();
        /* O id é o registro */
        $aluno = $this->Estudante->find('first', array(
            'conditions' => array('Estudante.registro' => $id)
                )
        );
        // pr($aluno);
        // die('aluno1');
        /* Tenta buscar pelo id e não pelo registro */    
        if (empty($aluno))
            $aluno = $this->Estudante->find('first', array(
                'conditions' => array('Estudante.id' => $id)
                    )
            );
        // pr($aluno);
        // die('aluno2');

        // Onde fizeram inscricoes
        if (!empty($aluno['Estudante']['registro'])) {
            // die($aluno['Estudante']['registro']);

            $this->loadModel('Inscricao');
            $inscricoes = $this->Inscricao->query('select * from muralinscricoes AS Inscricao INNER JOIN estudantes AS Estudante on Inscricao.aluno_id = Estudante.registro where Inscricao.aluno_id =' . $aluno['Estudante']['registro']);
            // $log = $this->Inscricao->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($inscricoes);
            // die('inscricoes');
            $i = 0;

            /* Verifico as inscricoes no mural */
            $this->loadModel('Muralestagio');
            foreach ($inscricoes as $c_inscricao):
                // pr($c_inscricao);
                // die('c_inscricao');
                $inscricoesmural = $this->Muralestagio->query('SELECT Muralestagio.id, Muralestagio.id_estagio, Muralestagio.instituicao, Muralestagio.periodo '
                        . 'FROM muralestagios AS Muralestagio '
                        . 'LEFT JOIN muralinscricoes AS Inscricao ON Muralestagio.id = Inscricao.mural_estagio_id '
                        . 'WHERE Muralestagio.id = ' . $c_inscricao['Inscricao']['mural_estagio_id'] . ' && Inscricao.aluno_id = ' . $aluno['Estudante']['registro']);
                // $log = $this->Muralestagio->getDataSource()->getLog(false, false);
                // debug($log);
                // pr($inscricoesmural);
                // die('inscricoesmural');
                foreach ($inscricoesmural as $c_inscricoesmural):
                    $inscricoesnomural[$i]['inscricao_id'] = $c_inscricao['Inscricao']['id'];
                    $inscricoesnomural[$i]['id'] = $c_inscricoesmural['Muralestagio']['id'];
                    $inscricoesnomural[$i]['id_estagio'] = $c_inscricoesmural['Muralestagio']['id_estagio'];
                    $inscricoesnomural[$i]['instituicao'] = $c_inscricoesmural['Muralestagio']['instituicao'];
                    $inscricoesnomural[$i]['periodo'] = $c_inscricoesmural['Muralestagio']['periodo'];
                    $i++;
                endforeach;
                // echo $i . "<br>";

            endforeach;
            // pr($inscricoesnomural);
            // die('inscricaoesnomural');
            if (isset($inscricoenosmural)) {
                $this->set('inscricoes', $inscricoesnomural);
            }

            /* Estudantes não tem estágio!! */
            $this->loadModel('Estagiario');
            $estagios = $this->Estagiario->find('all', [
                'conditions' => ['Estagiario.registro' => $aluno['Estudante']['registro']]
                    ]
            );
            // pr($estagios);
            // die('Estagios');
            $this->set('estagios', $estagios);
        };
        // pr($aluno);
        // die("aluno");
        $this->set('alunos', $aluno);
    }

    public function delete($id = null) {

        // Pego o numero de registro
        $registro = $this->Estudante->findById($id, array('fields' => 'registro'));

        // Pego as inscricoes realizadas
        $this->loadModel('Inscricao');
        $inscricao = $this->Inscricao->find('all', array(
            'conditions' => array('Inscricao.aluno_id' => $registro['Estudante']['registro']),
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

        $this->Estudante->delete($id);

        $this->Session->setFlash("Registro excluído (junto com as inscrições)");
        $this->redirect("/Inscricoes/index/");
    }

    public function padroniza() {
        $alunos = $this->Estudante->find('all', array('fields' => array('id', 'nome', 'email', 'endereco', 'bairro')));
        // pr($alunos);
        // die();
        foreach ($alunos as $c_aluno):

            if ($c_aluno['Estudante']['email']):
                $email = strtolower($c_aluno['Estudante']['email']);
                $this->Alunonovo->query("UPDATE estudantes set email = " . "\"" . $email . "\"" . " where id = " . $c_aluno['Estudante']['id']);
            endif;

            if ($c_aluno["Estudante"]['nome']):
                $nome = ucwords(strtolower($c_aluno['Estudante']['nome']));
                $this->Estudante->query("UPDATE estudantes set nome = " . "\"" . $nome . "\"" . " where id = " . $c_aluno['Estudante']['id']);
            endif;

            if ($c_aluno['Estudante']['endereco']):
                $endereco = ucwords(strtolower($c_aluno['Estudante']['endereco']));
                $this->Estudante->query("UPDATE estudantes set endereco = " . "\"" . $endereco . "\"" . " where id = " . $c_aluno['Estudante']['id']);
            endif;

            if ($c_aluno['Estudante']['bairro']):
                $bairro = ucwords(strtolower($c_aluno['Estudante']['bairro']));
                $this->Estudante->query("UPDATE estudantes set bairro = " . "\"" . $bairro . "\"" . " where id = " . $c_aluno['Estudante']['id']);
            endif;

        endforeach;
    }

}
