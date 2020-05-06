<?php

class EstudantesController extends AppController {

    public $name = "Estudantes";
    public $components = ['Auth'];

    public $paginate = [
        'limit' => 25,
        'contain' => ['Estudante'],
        'order' => ['Estudante.nome']
        
    ];
    
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

        $this->Paginator->settings = $this->paginate;
        $estudantes = $this->Paginator->paginate('Estudante');
        $this->set('estudantes', $estudantes);
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde Inscricao function add 
     * e tambem desde Inscricao function termo de compromisso
     */

    public function add($id = null) {

        $parametros = $this->params['named'];
        $registro = isset($parametros['registro']) ? $parametros['registro'] : NULL;

        $registrologin = $this->Session->read('numero');
        if ($registro != $registrologin) {
            if ($this->Session->read('id_categoria') === '2') {
                $this->setFlash(__('Realize login com seu número de DRE'));
                $this->redirect('/Userestagios/login');
            }
        }
        /*
         * Se o registro está como parámetro então verifico se tem o id do mural_estagio_id
         */
        if ($registro) {
            $mural_estagio_id = $this->Session->read('mural_estagio_id');
        }

        if ($this->Estudante->save($this->data)) {

            // Capturo o id do mural_estagio_id (se foi chamada desde Inscricoes add)
            $mural_estagio_id = $this->Session->read('mural_estagio_id');

            // Verifico se foi chamado desde a solicitacao do termo
            $registro_termo = $this->Session->read('termo');
            // Acho que posso apagar aqui porque nao vai ser chamado novamente
            $this->Session->delete('termo');

            // Vejo se foi chamado desde cadastro
            $cadastro = $this->Session->read('cadastro');

            $registro = $this->data['Estudante']['registro'];
            $this->Session->setFlash(__("Cadastro realizado: " . $registro));

            if ($mural_estagio_id) {
                // Volta para a pagina de Inscricoes
                // die("inscricao_seleciona_estagio");
                $this->redirect("/Inscricoes/inscricao/registro:" . $registro . "/mural_estagio_id:" . $mural_estagio_id);
            } elseif ($registro_termo) {
                // Volta para a pagina Inscricoes e vai para termocompromisso
                // die(" registro_termo " . $registro_termo);
                $this->redirect("/Inscricoes/termocompromisso/" . $registro_termo);
                die("Redireciona para concluir solicitacao de termo de compromisso");
            } elseif ($cadastro) {
                // die("cadastro");
                $this->Session->delete('cadastro');
                $this->Session->write('menu_aluno', 'alunonovo');
                $this->Session->write('menu_id_aluno', $this->Estudante->id);
                $this->redirect("/Estudantes/view/" . $this->Estudante->id);
            } else {
                // Mostra resultado da insercao
                $this->Session->write('menu_aluno', 'alunonovo');
                $this->Session->write('menu_id_aluno', $this->Estudante->id);
                $this->Session->setFlash('Dados inseridos');
                $this->redirect("/Estudantes/view/" . $this->Estudante->id);
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

        // pr($id);
        $parametros = $this->params['named'];
        $mural_estagio_id = isset($parametros['mural_estagio_id']) ? $parametros['mural_estagio_id'] : null;
        $registro = isset($parametros['id']) ? $parametros['id'] : null;
        // pr($mural_estagio_id);
        // pr('registro: ' . $registro);

        /*
         * Se o Id não veio como parámetro calculo o Id a partir do registro
         */
        if (!$id) {
            $identificador = $this->Estudante->find('first', [
                'conditions' => ['Estudante.registro' => $registro],
                'fields' => ['id']
            ]);
            if ($identificador) {
                $id = $identificador['Estudante']['id'];
            } else {
                $this->Session->setFlash(__("Erro no identificador"));
                $this->redirect("/Muralestagios/index");
            }
        }
        // pr($id);
        // die('id2');

        /*
         *  Verifica se está autorizado a editar: somente o próprio pode editar
         */
        if ($this->Session->read('numero')) {
            $estudante_id = $this->Estudante->find('first', [
                'fields' => ['id'],
                'conditions' => ['Estudante.id' => $id]
            ]);
            // pr($estudante_id['Estudante']['id']);
            // die();
            if ($estudante_id['Estudante']['id'] != $id) {
                $this->Session->setFlash(__("Acesso não autorizado"));
                $this->redirect("/Muralestagios/index");
                die("Não autorizado");
            }
        }

        $this->Estudante->id = $id;
        // pr($this->Estudante->id);
        // pr($id);
        // pr($this->data);
        // die('this->data');
        /*
         * Captura o valores do formulário, verifica e salva.
         * 
         */
        if (empty($this->data)) {
            $this->data = $this->Estudante->read();
            // pr($this->data);
            // die('this->data2');
        } else {
            $duplicada = $this->Estudante->find('first', [
                'conditions' => ['Estudante.registro' => $this->data['Estudante']['registro']]
            ]);
            if ($duplicada) {
                $this->Session->setFlash(__("O número de aluno já está cadastrado"));
            }

            if ($this->Estudante->save($this->data)) {
                $this->Session->setFlash(_("Atualizado"));

                /*
                 * Capturo o mural_estagio_id para saber que foi chamada desde Inscriacoes add)
                 * Acho que não é mais necessário porque já veio como parámetro
                 */
                // $mural_estagio_id = $this->Session->read('mural_estagio_id');
                // $this->Session->delete('mural_estagio_id');

                /*
                 *  Capturo se foi chamado desde a solicitacao do termo
                 */
                $registro_termo = $this->Session->read('termo');
                $this->Session->delete('termo');

                /*
                 * Volta para Inscricoes e via para o método inscricao com o 
                 * registro e o mural_estagio_id como parámetros
                 */
                if ($mural_estagio_id) {
                    // Faz inscricao para selecao de estagio
                    $this->Session->setFlash(__("Inscricao para selecao de estagio"));
                    $this->redirect('/Inscricoes/inscricao/registro:' . $this->data['Estudante']['registro'] . '/mural_estagio_id:' . $mural_estagio_id);
                } elseif (!empty($registro_termo)) {
                    // Solicita termo de compromisso
                    $this->Session->setFlash(__("Solicitacao de termo de compromisso"));
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
            $inscricoes = $this->Inscricao->query('select * FROM muralinscricoes AS Inscricao '
                    . ' LEFT JOIN estudantes AS Estudante ON Inscricao.aluno_id = Estudante.registro '
                    . ' LEFT JOIN muralestagios As Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                    . ' WHERE Inscricao.aluno_id =' . $aluno['Estudante']['registro']);
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
                $inscricoesnomural[$i]['inscricao_id'] = $c_inscricao['Inscricao']['id'];
                $inscricoesnomural[$i]['id'] = $c_inscricao['Muralestagio']['id'];
                $inscricoesnomural[$i]['id_estagio'] = $c_inscricao['Muralestagio']['id_estagio'];
                $inscricoesnomural[$i]['instituicao'] = $c_inscricao['Muralestagio']['instituicao'];
                $inscricoesnomural[$i]['periodo'] = $c_inscricao['Muralestagio']['periodo'];
                $i++;
                // echo $i . "<br>";
            endforeach;
            // pr($inscricoesnomural);
            // die('inscricaoesnomural');
            if (isset($inscricoesnomural)) {
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
