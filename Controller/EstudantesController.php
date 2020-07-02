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
        // pr($parametros);
        // pr($id);
        // die('registro');

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

        if ($this->Estudante->save($this->request->data)) {

            // Capturo o id do mural_estagio_id (se foi chamada desde Inscricoes add)
            $mural_estagio_id = $this->Session->read('mural_estagio_id');

            // Verifico se foi chamado desde a solicitacao do termo
            $registro_termo = $this->Session->read('termo');
            // Acho que posso apagar aqui porque nao vai ser chamado novamente
            $this->Session->delete('termo');

            // Vejo se foi chamado desde cadastro
            $cadastro = $this->Session->read('cadastro');

            $registro = $this->data['Estudante']['registro'];

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
                $this->Session->setFlash(__('Dados inseridos'));
                $this->redirect("/Estudantes/view/" . $this->Estudante->id);
            }
            $this->Session->setFlash(__("Cadastro realizado: " . $registro));
            $this->redirect('/Estudante/view/' . $this->Estudante->id);
        }
        if ($registro) {
            $this->set('registro', $registro);
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

        $parametros = $this->params['named'];
        $registro = isset($parametros['registro']) ? $parametros['registro'] : NULL;
        // pr($registro);
        // die();
        
        /* 1 - Verifica se pode ter acesso ou não a esta função */
        if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero'))) {

            if (isset($registro)) {
                if ($registro != $this->Session->read('numero')) {
                    // die('Diferente');
                    $this->Session->setFlash(__("Acesso não autorizado por erro de registro"));
                    $this->redirect("/Muralestagios/index");
                    die("Não autorizado");
                }
            }

            $verifica = $this->Estudante->find('first', [
                'conditions' => ['Estudante.registro' => $this->Session->read('numero')]
            ]);
            // pr($this->Session->read('numero'));
            // echo $id . "<br>";
            // die();
            if (isset($id)) {
                if ($id != $verifica['Estudante']['id']) {
                    $this->Session->setFlash(__("Acesso não autorizado por erro de id"));
                    $this->redirect("/Muralestagios/index");
                    die("Não autorizado id");
                }
            }
        }
        // die('acesso');
        
        /* 2 - Capturo os dados pessoais */
        if ($id) {
            $estudante = $this->Estudante->find('first', array(
                'conditions' => array('Estudante.id' => $id)
                    )
            );
        } elseif ($registro) {
            $estudante = $this->Estudante->find('first', array(
                'conditions' => array('Estudante.registro' => $registro)
                    )
            );
        }
        // pr($estudante);
        // die('dados pessoais do estudante');

        /* 3 - Capturo as inscrições */
        $inscricoes = $this->Estudante->Inscricao->find('all', [''
            . 'conditions' => ['Inscricao.estudante_id' => $id]]);

        // pr($inscricoes);
        // die('inscricoes');

        $i = 0;
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

        /* 4 - Capturo os estágios */
        $estagios = $this->Estudante->Estagiario->find('all', [
            'conditions' => ['Estagiario.estudante_id' => $id]
                ]
        );
        // pr($estagios);
        // die('Estagios');
        if ($estagios) {
            $this->set('estagios', $estagios);
        }

        // pr($aluno);
        // die("aluno");
        $this->set('alunos', $estudante);
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

    public function busca($nome = NULL) {

        // Para paginar os resultados da busca por nome
        if (isset($nome))
            $this->request->data['Estudante']['nome'] = $nome;

        $nome = isset($nome) ? $this->request->data : null;
        // echo $nome;
        // die('nome');

        $this->Paginate = array(
            'limit' => 10,
            'order' => array(
                'Estudante.nome' => 'asc')
        );

        if (!empty($this->data['Estudante']['nome'])) {

            $condicao = array('Estudante.nome like' => '%' . $this->data['Estudante']['nome'] . '%');
            $alunos = $this->Estudante->find('all', array('conditions' => $condicao));
            // pr($alunos);
            // die();
            // Nenhum resultado
            if (!empty($alunos)) {
                $this->set('alunos', $this->paginate('Estudante', $condicao));
                $this->set('nome', $this->data['Estudante']['nome']);
            } else {
                $this->Session->setFlash(__('Não foram encontrados estudantes com esse nome'));
                $this->redirect('/Estudantes/busca/');
            }
        }
    }

    public function busca_dre() {

        if (!empty($this->data['Estudante']['registro'])) {
            $alunos = $this->Estudante->find('all', [
                'conditions' => ['Estudante.registro' => $this->data['Estudante']['registro']]
            ]);
            // pr($alunos);
            // die('alunos');
            if (empty($alunos)) {
                $this->Session->setFlash(__("Não foram encontrados registros do estudante"));
                $this->redirect('/Estudantes/busca');
            } else {
                $this->set('estudantes', $alunos);
            }
        }
    }

    public function busca_email() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Estudante->find('all', [
                'conditions' => ['Estudante.email' => $this->data['Estudante']['email']]]);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Session->setFlash(__("Não foram encontrados estudantes com esse email"));
                $this->redirect('/Estudantes/busca');
            } else {
                $this->set('estudantes', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function busca_cpf() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Estudante->find('all', [
                'conditions' => ['Estudante.cpf' => $this->data['Estudante']['cpf']]
            ]);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Session->setFlash(__("Não foram encontrados estudantes com o CPF"));
                $this->redirect('/Estudantes/busca');
            } else {
                $this->set('estudantes', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function cargahoraria($ordem = NULL) {

        $parametros = $this->params['named'];
        // pr($parametros);
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : NULL;

        if (empty($ordem)):
            $ordem = 'q_semestres';
        endif;

        // pr($ordem);
        // die();

        $alunos = $this->Estudante->find('all');

        // pr($alunos);
        // die('Alunos');

        $i = 0;
        $this->loadModel('Estagiario');
        foreach ($alunos as $c_aluno):
            // pr($c_aluno);
            // die('c_aluno');
            // if (sizeof($c_aluno['Estagiario']) >= 4):
            // pr(sizeof($c_aluno['Estagiario']));
            $cargahorariatotal[$i]['id'] = $c_aluno['Estudante']['id'];
            $cargahorariatotal[$i]['registro'] = $c_aluno['Estudante']['registro'];
            $cargahorariatotal[$i]['nome'] = $c_aluno['Estudante']['nome'];
            $estagios = $this->Estagiario->find('all', [
                'conditions' => ['Estagiario.registro' => $c_aluno['Estudante']['registro']]
            ]);
            // pr(sizeof($estagios));
            // die('estagios');
            $cargahorariatotal[$i]['q_semestres'] = sizeof($estagios);

            $carga_estagio['ch'] = NULL;
            $y = 0;
            foreach ($estagios as $c_estagio):
                // pr($c_estagio['Estagiario']['periodo']);
                // die('c_estagio');
                $ultimoperiodo = $c_estagio['Estagiario']['periodo'];
                if ($c_estagio['Estagiario']['nivel'] == 1):
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['Estagiario']['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['Estagiario']['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['Estagiario']['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['Estagiario']['ch'];
                // $criterio[$i][$ordem] = $c_estagio['Estagiario']['periodo'];
                else:
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['Estagiario']['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['Estagiario']['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['Estagiario']['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['Estagiario']['ch'];
                // $criterio[$i][$ordem] = NULL;
                endif;
                $y++;
                // die('y');
            endforeach;
            // echo $ultimoperiodo . "<br>";
            $cargahorariatotal[$i]['ultimoperiodo'] = $ultimoperiodo;
            // die('c_estagio');
            $cargahorariatotal[$i]['ch_total'] = $carga_estagio['ch'];
            $criterio[$i] = $cargahorariatotal[$i][$ordem];
            $i++;
//            endif;
        endforeach;

        array_multisort($criterio, SORT_ASC, $cargahorariatotal);
        // pr($cargahorariatotal);
        $this->set('cargahorariatotal', $cargahorariatotal);

        // die();
    }

    public function planilhacress($id = NULL) {

        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'estudante';
        // pr($periodo);
        // die();
        // $periodo = '2015-2';

        $this->loadModel('Estagiario');
        $periodototal = $this->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')));

        // pr($totalperiodo);
        // die();
        $periodosunicos = array_unique($periodototal);
        foreach ($periodosunicos as $c_periodo):
            $periodos[$c_periodo] = $c_periodo;
        endforeach;

        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $estagiario = $this->Estagiario->find('all', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.registro', 'Estagiario.instituicao_id', 'Estagiario.supervisor_id', 'Estagiario.docente_id'),
            'conditions' => array('Estagiario.periodo' => $periodo),
            'order' => array('Estudante.nome')
        ));
        // pr($estagiario);
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        // die('estagiario');

        /* 'Estagiario.periodo'
         * 'Estudante.id',
         * 'Estudante.nome',
         * 'Instituicao.id',
         * 'Instituicao.instituicao',
         * 'Instituicao.cep',
         * 'Instituicao.endereco',
         * 'Instituicao.bairro',
         * 'Supervisor.nome',
         * 'Supervisor.cress',
         * 'Professor.nome'),
         */

        $this->loadModel('Instituicao');
        $this->loadModel('Supervisor');
        $this->loadModel('Professor');
        $i = 0;
        foreach ($estagiario as $c_estagiario) {
            // pr($c_estagiario);
            $estudante = $this->Estudante->find('first', [
                'fields' => ['Estudante.id', 'Estudante.nome'],
                'conditions' => ['Estudante.registro' => $c_estagiario['Estagiario']['registro']]
            ]);
            $instituicao = $this->Instituicao->find('first', [
                'fields' => ['Instituicao.id', 'Instituicao.instituicao', 'Instituicao.cep', 'Instituicao.endereco', 'Instituicao.bairro'],
                'conditions' => ['Instituicao.id' => $c_estagiario['Estagiario']['instituicao_id']]
            ]);
            $supervisor = $this->Supervisor->find('first', [
                'fields' => ['Supervisor.id', 'Supervisor.nome', 'Supervisor.cress'],
                'conditions' => ['Supervisor.id' => $c_estagiario['Estagiario']['supervisor_id']]
            ]);
            $professor = $this->Professor->find('first', [
                'fields' => ['Professor.id', 'Professor.nome'],
                'conditions' => ['Professor.id' => $c_estagiario['Estagiario']['docente_id']]
            ]);
            // pr($professor);
            // die();
            $planilhacress[$i]['periodo'] = $c_estagiario['Estagiario']['periodo'];
            $planilhacress[$i]['estudante'] = $estudante['Estudante']['nome'];
            $planilhacress[$i]['registro'] = $c_estagiario['Estagiario']['registro'];

            if ($instituicao) {
                $planilhacress[$i]['instituicao_id'] = $instituicao['Instituicao']['id'];
                $planilhacress[$i]['instituicao'] = $instituicao['Instituicao']['instituicao'];
                $planilhacress[$i]['cep'] = $instituicao['Instituicao']['cep'];
                $planilhacress[$i]['endereco'] = $instituicao['Instituicao']['endereco'];
                $planilhacress[$i]['bairro'] = $instituicao['Instituicao']['bairro'];
            } else {
                $planilhacress[$i]['instituicao'] = null;
                $planilhacress[$i]['cep'] = null;
                $planilhacress[$i]['endereco'] = null;
                $planilhacress[$i]['bairro'] = null;
            }
            if ($supervisor) {
                $planilhacress[$i]['cress'] = $supervisor['Supervisor']['cress'];
                $planilhacress[$i]['supervisor'] = $supervisor['Supervisor']['nome'];
            } else {
                $planilhacress[$i]['cress'] = null;
                $planilhacress[$i]['supervisor'] = null;
            }
            if ($professor) {
                $planilhacress[$i]['professor'] = $professor['Professor']['nome'];
            } else {
                $planilhacress[$i]['professor'] = null;
            }
            $i++;
        }
        // pr($estudante);
        // pr($instituicao);
        // pr($supervisor);
        // pr($professor);
        array_multisort(array_column($planilhacress, $ordem), $planilhacress);
        // pr($planilhacress);
        // die();
        // pr($cress);
        $this->set('cress', $planilhacress);
        $this->set('periodos', $periodos);
        $this->set('periodoatual', $periodo);
        // die();
    }

    public function planilhaseguro($id = NULL) {

        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        // pr($periodo);
        // die();
        // $periodo = '2015-2';
        $ordem = 'nome';

        $this->loadModel('Estagiario');
        $periodototal = $this->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')));

        // pr($totalperiodo);
        // die();
        $periodosunicos = array_unique($periodototal);
        foreach ($periodosunicos as $c_periodo):
            $periodos[$c_periodo] = $c_periodo;
        endforeach;

        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $seguro = $this->Estagiario->find('all', array(
            'fields' => array('Estagiario.id', 'Estagiario.registro', 'Estagiario.periodo', 'Estagiario.nivel', 'Estagiario.instituicao_id'),
            'conditions' => array('Estagiario.periodo' => $periodo),
            'order' => array('Estagiario.nivel')
        ));
        // pr($estagiario);
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        // die('estagiario');

        /* 'Estagiario.periodo'
         * 'Estudante.id',
         * 'Estudante.registro'
         * 'Estudante.nome',
         * 'Estudante.cpf',
         * 'Estudante.nascimento',
         * 'Estagiario.nivel',
         * 'Estagiario.periodo',
         * 'Instituicao.id',
         * 'Instituicao.instituicao',
         */

        // pr($seguro);
        // die();
        $this->loadModel('Instituicao');
        $i = 0;
        foreach ($seguro as $c_seguro) {
            // pr($c_seguro);
            // die();
            if ($c_seguro['Estagiario']['nivel'] == 1) {

                // Início
                $inicio = $c_seguro['Estagiario']['periodo'];

                // Final
                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $novoindicasemestre = $indicasemestre + 1;
                    $final = $novoano . "-" . $novoindicasemestre;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 2;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 2) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $novoano = $ano - 1;
                    $inicio = $novoano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $inicio = $ano . "-" . "1";
                }

                // Final
                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . "2";
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 3) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                $novoano = $ano - 1;
                $inicio = $novoano . "-" . $indicasemestre;

                // Final
                if ($indicasemestre == 1) {
                    // $ano = $ano + 1;
                    $final = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 4) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 1;
                    $inicio = $ano . "-" . 1;
                }

                // Final
                $final = $c_seguro['Estagiario']['periodo'];

                // Estagio não obrigatório. Conto como estágio 9
            } elseif ($c_seguro['Estagiario']['nivel'] == 9) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                }

                // Final
                $final = $c_seguro['Estagiario']['periodo'];

                // echo "Nível: " . $c_seguro['Estagiario']['nivel'] . " Período: " . $c_seguro['Estagiario']['periodo'] . " Início: " . $inicio . " Final: " . $final . '<br>';
            }
            $estudante = $this->Estudante->find('first', [
                'fields' => ['Estudante.id', 'Estudante.nome', 'Estudante.cpf', 'Estudante.nascimento', 'Estudante.registro'],
                'conditions' => ['Estudante.registro' => $c_seguro['Estagiario']['registro']]
            ]);
            // pr($estudante);
            // die();
            $t_seguro[$i]['id'] = $estudante['Estudante']['id'];
            $t_seguro[$i]['nome'] = $estudante['Estudante']['nome'];
            $t_seguro[$i]['cpf'] = $estudante['Estudante']['cpf'];
            $t_seguro[$i]['nascimento'] = $estudante['Estudante']['nascimento'];
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $estudante['Estudante']['registro'];
            $t_seguro[$i]['curso'] = "UFRJ/Serviço Social";
            if ($c_seguro['Estagiario']['nivel'] == 9):
                // pr("Não");
                $t_seguro[$i]['nivel'] = "Não obrigatório";
            else:
                // pr($c_seguro['Estagiario']['nivel']);
                $t_seguro[$i]['nivel'] = $c_seguro['Estagiario']['nivel'];
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro['Estagiario']['periodo'];
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            $instituicao = $this->Instituicao->find('first', [
                'fields' => ['Instituicao.id', 'Instituicao.instituicao'],
                'conditions' => ['Instituicao.id' => $c_seguro['Estagiario']['instituicao_id']]
            ]);
            // pr($instituicao);
            // die();
            $t_seguro[$i]['instituicao'] = $instituicao['Instituicao']['instituicao'];

            $i++;
        }
        if (!empty($t_seguro)) {
            array_multisort(array_column($t_seguro, $ordem), SORT_ASC, $t_seguro);
        }
        // pr($t_seguro);
        // die();
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
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
