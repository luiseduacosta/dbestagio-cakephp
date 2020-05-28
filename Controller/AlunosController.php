<?php

class AlunosController extends AppController {

    public $name = 'Alunos';
    public $components = array('Auth');
    public $paginate = [
        'limit' => 15,
        'order' => [
            ['Aluno.nome' => 'asc']
        ]
    ];

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit', 'avaliacaosolicita', 'avaliacaoverifica', 'avaliacaoedita', 'avaliacaoimprime', 'folhadeatividades');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/Userestagios/login/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->paginate = array(
            'limit' => 15,
            'order' => array(
                'Aluno.nome' => 'asc')
        );

        $this->set('alunos', $this->paginate('Aluno'));
    }

    public function view($id = NULL) {

        // echo "Aluno";
        // die(pr($this->Session->read('numero')));
        // Se eh estudante somente o próprio pode ver
        // echo $this->Session->read('numero');
        // die();
        if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero'))) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Aluno->findByRegistro($this->Session->read('numero'));
            if ($id != $verifica['Aluno']['id']) {
                $this->Session->setFlash(__("Acesso não autorizado"));
                $this->redirect("/Murals/index");
                die("Aceso não autorizado");
            }
        }

        // $this->loadModel('Estagiario');
        $instituicao = $this->Aluno->findById($id);
        // pr($instituicao);
        // die();
        $aluno = $instituicao['Aluno'];
        $estagios = $instituicao['Estagiario'];

        // Pego a informacao sobre o conteudo dos estagios realizados
        $instituicoes = $this->Aluno->Estagiario->find('all', array(
            'conditions' => array('Estagiario.aluno_id' => $id)
                )
        );
        // pr($instituicoes);
        // die();
        // Para ordernar o array por nivel de estágio
        $i = 0;
        $y = 0;
        foreach ($instituicoes as $c_instituicao) {

            // pr($c_instituicao);

            if ($c_instituicao['Estagiario']['nivel'] < 9):

                $ordem = 'nivel';
                $c_estagios[$i]['id'] = $c_instituicao['Estagiario']['id'];
                $c_estagios[$i]['periodo'] = $c_instituicao['Estagiario']['periodo'];
                $c_estagios[$i]['nivel'] = $c_instituicao['Estagiario']['nivel'];
                $c_estagios[$i]['turno'] = $c_instituicao['Estagiario']['turno'];
                $c_estagios[$i]['tc'] = $c_instituicao['Estagiario']['tc'];
                $c_estagios[$i]['instituicao_id'] = $c_instituicao['Instituicao']['id'];
                $c_estagios[$i]['instituicao'] = $c_instituicao['Instituicao']['instituicao'];
                $c_estagios[$i]['docente_id'] = $c_instituicao['Professor']['id'];
                $c_estagios[$i]['professor'] = $c_instituicao['Professor']['nome'];
                $c_estagios[$i]['supervisor_id'] = $c_instituicao['Supervisor']['id'];
                $c_estagios[$i]['supervisor'] = $c_instituicao['Supervisor']['nome'];
                $c_estagios[$i]['areaestagio_id'] = $c_instituicao['Areaestagio']['id'];
                $c_estagios[$i]['areaestagio'] = $c_instituicao['Areaestagio']['area'];
                $c_estagios[$i]['nota'] = $c_instituicao['Estagiario']['nota'];
                $c_estagios[$i]['ch'] = $c_instituicao['Estagiario']['ch'];
                $criterio[$i] = $c_estagios[$i][$ordem];

                $i++;

            elseif ($c_instituicao['Estagiario']['nivel'] == 9):

                $ordem = 'periodo';
                $nao_estagios[$y]['id'] = $c_instituicao['Estagiario']['id'];
                $nao_estagios[$y]['periodo'] = $c_instituicao['Estagiario']['periodo'];
                $nao_estagios[$y]['nivel'] = $c_instituicao['Estagiario']['nivel'];
                $nao_estagios[$y]['turno'] = $c_instituicao['Estagiario']['turno'];
                $nao_estagios[$y]['tc'] = $c_instituicao['Estagiario']['tc'];
                $nao_estagios[$y]['instituicao_id'] = $c_instituicao['Instituicao']['id'];
                $nao_estagios[$y]['instituicao'] = $c_instituicao['Instituicao']['instituicao'];
                $nao_estagios[$y]['docente_id'] = $c_instituicao['Professor']['id'];
                $nao_estagios[$y]['professor'] = $c_instituicao['Professor']['nome'];
                $nao_estagios[$y]['supervisor_id'] = $c_instituicao['Supervisor']['id'];
                $nao_estagios[$y]['supervisor'] = $c_instituicao['Supervisor']['nome'];
                $nao_estagios[$y]['id_area'] = $c_instituicao['Area']['id'];
                $nao_estagios[$y]['area'] = $c_instituicao['Area']['area'];
                $nao_estagios[$y]['nota'] = $c_instituicao['Estagiario']['nota'];
                $nao_estagios[$y]['ch'] = $c_instituicao['Estagiario']['ch'];
                $nao_criterio[$y] = $nao_estagios[$y][$ordem];

                $y++;

            endif;
        }

        array_multisort($criterio, SORT_ASC, $c_estagios);
        if (isset($nao_estagios) && !(empty($nao_estagios))):
            array_multisort($nao_criterio, SORT_ASC, $nao_estagios);
            $this->set('nao_obrigatorio', $nao_estagios);
        endif;
        // pr($c_estagios);
        // pr($nao_estagios);

        $this->set('c_estagios', $c_estagios);

        $proximo = $this->Aluno->find('neighbors', array(
            'field' => 'nome', 'value' => $aluno['nome']));

        $this->set('registro_next', $proximo['next']['Aluno']['id']);
        $this->set('registro_prev', $proximo['prev']['Aluno']['id']);
        // $this->set('alunos', $this->paginate('Aluno', array('id'=>$id)));
        $this->set('alunos', $aluno);
        $this->set('estagios', $estagios);
    }

    public function planilhacress($id = NULL) {

        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        // pr($periodo);
        // die();
        // $periodo = '2015-2';
        $ordem = 'Aluno.nome';

        $periodototal = $this->Aluno->Estagiario->find('list', array(
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

        $cress = $this->Aluno->Estagiario->find('all', array(
            'fields' => array('Estagiario.periodo', 'Aluno.id', 'Aluno.nome', 'Instituicao.id', 'Instituicao.instituicao', 'Instituicao.cep', 'Instituicao.endereco', 'Instituicao.bairro', 'Supervisor.nome', 'Supervisor.cress', 'Professor.nome'),
            'conditions' => array('Estagiario.periodo' => $periodo),
            'order' => array('Aluno.nome')
        ));

        // pr($cress);
        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoatual', $periodo);
        // die();
    }

    public function edit($id = NULL) {

        if ($this->Session->read('numero')) {
            $verifica = $this->Aluno->findByRegistro($this->Session->read('numero'));
            if ($id != $verifica['Aluno']['id']) {
                $this->Session->setFlash(__("Acesso não autorizado"));
                $this->redirect("/Murals/index");
                die("Não autorizado");
            }
        }

        $this->Aluno->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Aluno->read();
        } else {

            $duplicada = $this->Aluno->findByRegistro($this->data['Aluno']['registro']);
            if ($duplicada)
                $this->Session->setFlash(__("Este número de aluno já está cadastrado"));

            if ($this->Aluno->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash(__("Atualizado"));

                // Verfico se esta fazendo inscricao para selecao de estagio
                $inscricao_selecao_estagio = $this->Session->read('instituicao_id');
                // Ainda nao posso apagar
                // $this->Session->delete('instituicao_id');
                // Verifico se foi chamado desde solicitacao do termo
                $registro_termo = $this->Session->read('termo');
                // $this->Session->delete('termo');

                if ($inscricao_selecao_estagio) {
                    $this->redirect('/Inscricoes/inscricao/' . $this->data['Aluno']['registro']);
                } elseif ($registro_termo) {
                    $this->redirect('/Inscricoes/termocompromisso/' . $registro_termo);
                } else {
                    $this->redirect('/Alunos/view/' . $id);
                }
            }
        }
    }

    public function delete($id = NULL) {

        // Se tem pelo menos um estagio nao excluir
        $estagiario = $this->Aluno->Estagiario->find('first', ['conditions' => ['Estagiario.aluno_id' => $id]]);
        if ($estagiario) {
            $this->Session->setFlash(__('Aluno com estágios não pode ser excluido. Exclua os estágios primeiro.'));
            $this->redirect(array('url' => 'view/' . $id));
        } else {
            $this->Aluno->delete($id);
            $this->Session->setFlash('O registro ' . $id . ' foi excluido.');
            $this->redirect(array('url' => 'index'));
        }
    }

    public function busca($nome = NULL) {

        // Para paginar os resultados da busca por nome
        if (isset($nome))
            $this->request->data['Aluno']['nome'] = $nome;

        // $nome = isset($nome) ? $this->request->data : null;

        $this->Paginate = array(
            'limit' => 10,
            'order' => array(
                'Aluno.nome' => 'asc')
        );

        if (!empty($this->data['Aluno']['nome'])) {

            $condicao = array('Aluno.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
            $alunos = $this->Aluno->find('all', array('conditions' => $condicao));
            // pr($alunos);
            // die();
            // Nenhum resultado
            if (empty($alunos)) {
                $this->loadModel('Estudante');
                $condicao = array('Estudante.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
                $alunonovos = $this->Estudanate->find('all', array('conditions' => $condicao));
                if (empty($alunonovos)) {
                    $this->Session->setFlash(__("Não foram encontrados registros"));
                } else {
                    $this->set('alunos', $this->paginate('Estudante', $condicao));
                    $this->set('nome', $this->data['Aluno']['nome']);
                }
            } else {
                $this->set('alunos', $this->paginate('Aluno', $condicao));
                $this->set('nome', $this->data['Aluno']['nome']);
            }
        }
    }

    public function busca_dre() {

        if (!empty($this->data['Aluno']['registro'])) {
            $alunos = $this->Aluno->findAllByRegistro($this->data['Aluno']['registro']);
            if (empty($alunos)) {
                // Teria que buscar na tabela alunos_novos
                $this->loadModel('Estudante');
                $alunonovos = $this->Estudante->findAllByRegistro($this->data['Aluno']['registro']);
                // pr($alunonovos);
                if (empty($alunonovos)) {
                    $this->Session->setFlash(__("Não foram encontrados registros do aluno"));
                    $this->redirect('/Alunos/busca');
                } else {
                    $this->set('alunos', $alunonovos);
                }
            } else {
                $this->set('alunos', $alunos);
            }
        }
    }

    /*
     * id eh o numero de registro
     */

    public function busca_email() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByEmail($this->data['Aluno']['email']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Session->setFlash(__("Não foram encontrados registros do email aluno"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunos/busca');
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function busca_cpf() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByCpf($this->data['Aluno']['cpf']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Session->setFlash(__("Não foram encontrados registros do CPF"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunos/busca');
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    /*
     * O id eh o numero de registro
     */

    public function add($id = NULL) {

        if (!empty($this->request->data)) {
            // pr($this->request->data);

            if ($this->Aluno->save($this->data)) {
                $this->Session->setFlash(__('Dados do aluno inseridos!'));
                $this->redirect('/Estagiarios/add/' . $this->Aluno->Id);
            }
        }

        if ($id) {

            // Primeiro verifico se ja nao esta cadastrado entre os Alunos e Estudantes
            $alunocadastrado = $this->Aluno->find('first', array(
                'conditions' => array('Aluno.registro' => $id)
            ));
            if (!empty($alunocadastrado)) {
                $this->Session->setFlash(__("Aluno já cadastrado"));
                $this->redirect('/Alunos/view/' . $alunocadastrado['Aluno']['id']);
            }

            // Logo busco entre os Estudantes
            $this->loadModel('Estudante');
            $alunonovo = $this->Estudante->find('first', array(
                'conditions' => array('Estudante.registro' => $id)
            ));
            // pr($alunonovo);
            if (empty($alunonovo)) {
                $this->Session->setFlash(__("Estudante sem cadastrado"));                
                $this->redirect('/Estudantes/add/' . $id);
            } else {
                $this->set('alunonovo', $alunonovo);
            }
            $this->set('registro', $id);            
        }
        // die();
    }

    /*
     * Funcao para atualizar dados do supervisor do estagiario
     */

    public function avaliacaosolicita() {

        // Verificar periodo da folha de avaliação
        // pr($this->data);
        if ($this->data) {
            $aluno = $this->Aluno->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $this->data['Aluno']['registro']),
                'order' => array('Estagiario.nivel DESC')
            ));
            // pr($aluno['Supervisor']);
            // die("avaliacao");
            if ($aluno) {
                if (!empty($aluno['Supervisor']['id'])) {
                    $this->Session->setFlash(__("Verificar e completar dados do supervisor da instituicao."));
                    // $this->redirect('/Alunos/avaliacaoverifica/' . $aluno['Supervisor']['id'] . '/' . $this->data['Aluno']['registro']);
                    $this->redirect('/Alunos/avaliacaoedita/supervisor_id:' . $aluno['Supervisor']['id'] . '/registro:' . $this->data['Aluno']['registro']);
                } else {
                    $this->Session->setFlash(__("Não foi indicado o supervisor da instituicao. Retorna para solicitar termo de compromisso"));
                    $this->redirect('/Inscricoes/termocompromisso/' . $aluno['Aluno']['registro']);
                }
            } else {
                $this->Session->setFlash(__("Não há estágios cadastrados para este estudante"));
            }
        }
    }

    public function avaliacaoverifica() {

        $registro = $this->request->params['pass'][1];
        $estagiario = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));

        if ($estagiario) {
            $this->set('professor', $estagiario['Professor']['nome']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
        }

        // $this->redirect('/Alunos/avaliacaoedita/' . $estagiario['Supervisor']['id'] . '/' . $this->$estagiario['Aluno']['registro']);
    }

    public function folhasolicita() {

        $categoria = $this->Session->read('id_categoria');
        if ($categoria == 1) {

            // pr($this->data);
            if (empty($this->data)) {
                $this->data = $this->Aluno->read();
            } else {
                // pr($this->data());
                $this->Session->write('numero', $this->data['Aluno']['DRE']);
                $this->redirect('folhadeatividades');
            }
        }
    }

    public function folhadeatividades() {

        $dre = $this->Session->read('numero');
        if (empty($dre)) {
            $this->redirect('folhasolicita');
        } else {
            // pr($dre);
            // die('dre');
            $estagiario = $this->Aluno->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $dre),
                'order' => array('Estagiario.nivel DESC')
            ));
            // pr($estagiario);
            // die('estagiario');
            $this->Session->delete('numero');

            if (!empty($estagiario)):
                $this->set('registro', $registro = $estagiario['Aluno']['registro']);
                $this->set('estudante', $estudante = $estagiario['Aluno']['nome']);
                $this->set('nivel', $nivel = $estagiario['Estagiario']['nivel']);
                $this->set('periodo', $periodo = $estagiario['Estagiario']['periodo']);
                $this->set('supervisor', $supervisor = $estagiario['Supervisor']['nome']);
                $this->set('cress', $cress = $estagiario['Supervisor']['cress']);
                $this->set('celular', $celular = '(' . $estagiario['Supervisor']['codigo_cel'] . ')' . $estagiario['Supervisor']['celular']);
                $this->set('instituicao', $instituicao = $estagiario['Instituicao']['instituicao']);
                $this->set('professor', $professor = $estagiario['Professor']['nome']);

                $this->response->header(array("Content-type: application/pdf"));
                $this->response->type("pdf");
                $this->layout = "pdf";
                $this->render();
            else:
                $this->Session->setFlash(__("Não há estágios cadastrados para este estudante"));
                $this->redirect('folhadeatividades');
            endif;
        }
    }

    public function avaliacaoedita() {

        // pr($this->params);
        $supervisor_id = $this->params['named']['supervisor_id'];
        $registro = $this->params['named']['registro'];

        // pr($registro);
        $estagiario = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));
        // pr($estagiario);
        if ($estagiario) {
            $this->set('aluno', $estagiario['Aluno']['nome']);
            $this->set('registro', $estagiario['Aluno']['registro']);
            $this->set('professor', $estagiario['Professor']['nome']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('supervisor_id', $estagiario['Supervisor']['id']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
            // die("empty");
        }
        // die("avaliacaoedita");

        $this->loadModel('Supervisor');
        $this->Supervisor->id = $supervisor_id;

        if (empty($this->data)) {
            // die("empty");
            $this->data = $this->Supervisor->read();
        } else {
            // print_r($this->data);
            // die("avaliacaoedita");

            if (!$this->data['Supervisor']['cress']) {
                $this->Session->setFlash(__("O número de CRESS é obrigatório"));
                $this->redirect('/Alunos/avaliacaosolicita/supervisor_id:' . $supervisor_id . '/registro:' . $registro);
                die("O número de Cress é obrigatório");
            }

            if (!$this->data['Supervisor']['nome']) {
                $this->Session->setFlash(__("O nome do supervisor é obrigatório"));
                $this->redirect('/Alunos/avaliacaoedita/supervisor_id:' . $supervisor_id . '/registro:' . $registro);
                die("O nome do supervisor é obrigatório");
            }

            if ((!$this->data['Supervisor']['celular']) && (!$this->data['Supervisor']['telefone'])) {
                $this->Session->setFlash(__("O número de telefone ou celular é obrigatório"));
                $this->redirect('/Alunos/avaliacaoedita/supervisor_id:' . $supervisor_id . '/registro:' . $registro);
                die("O número de telefone ou celular é obrigatório");
            }

            if (!$this->data['Supervisor']['email']) {
                $this->Session->setFlash(__("O endereço de email é obrigatório"));
                $this->redirect('/Alunos/avaliacaoedita/supervisor_id:' . $supervisor_id . '/registro:' . $registro);
                die("O email é obrigatório");
            }

            if ($this->Supervisor->save($this->data)) {
                // die();
                // pr($this->data);
                $this->Session->setFlash(__("Atualizado"));
                $this->redirect('/Alunos/avaliacaoimprime/registro:' . $registro);
            }
        }
    }

    public function avaliacaoimprime() {

        $registro = $this->request->params['named']['registro'];

        $aluno = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));

        // pr($aluno);
        // die();

        $estudante = $aluno['Aluno']['nome'];
        $registro = $aluno['Aluno']['registro'];
        $nivel = $aluno['Estagiario']['nivel'];
        $periodo = $aluno['Estagiario']['periodo'];
        $supervisor = $aluno['Supervisor']['nome'];
        $cress = $aluno['Supervisor']['cress'];
        $telefone = $aluno['Supervisor']['telefone'];
        $celular = $aluno['Supervisor']['celular'];
        $email = $aluno['Supervisor']['email'];
        $instituicao = $aluno['Instituicao']['instituicao'];
        $endereco_inst = $aluno['Instituicao']['endereco'];
        $professor = $aluno['Professor']['nome'];

        $this->set('estudante', $estudante);
        $this->set('registro', $registro);
        $this->set('nivel', $nivel);
        $this->set('periodo', $periodo);
        $this->set('supervisor', $supervisor);
        $this->set('cress', $cress);
        $this->set('telefone', $telefone);
        $this->set('celular', $celular);
        $this->set('email', $email);
        $this->set('instituicao', $instituicao);
        $this->set('endereco_inst', $endereco_inst);
        $this->set('professor', $professor);

        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

    public function planilhaseguro($id = NULL) {

        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        // pr($periodo);
        // die();
        // $periodo = '2015-2';
        $ordem = 'nome';

        $periodototal = $this->Aluno->Estagiario->find('list', array(
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

        $seguro = $this->Aluno->Estagiario->find('all', array(
            'fields' => array('Aluno.id', 'Aluno.nome', 'Aluno.cpf', 'Aluno.nascimento', 'Aluno.registro',
                'Estagiario.nivel', 'Estagiario.periodo',
                'Instituicao.instituicao'),
            'conditions' => array('Estagiario.periodo' => $periodo),
            'order' => array('Estagiario.nivel')));

        // pr($seguro);
        // die();
        $i = 0;
        foreach ($seguro as $c_seguro) {

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

                // Estagio não obrigatório. Conto como estágio 5
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

            $t_seguro[$i]['id'] = $c_seguro['Aluno']['id'];
            $t_seguro[$i]['nome'] = $c_seguro['Aluno']['nome'];
            $t_seguro[$i]['cpf'] = $c_seguro['Aluno']['cpf'];
            $t_seguro[$i]['nascimento'] = $c_seguro['Aluno']['nascimento'];
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $c_seguro['Aluno']['registro'];
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
            $t_seguro[$i]['instituicao'] = $c_seguro['Instituicao']['instituicao'];
            $criterio[$i] = $t_seguro[$i][$ordem];

            $i++;
        }
        if (!empty($t_seguro)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        // pr($t_seguro);
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
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

        $alunos = $this->Aluno->find('all');

        // pr($alunos);
        $i = 0;
        foreach ($alunos as $c_aluno):
            // pr($c_aluno);
            // if (sizeof($c_aluno['Estagiario']) >= 4):
            // pr(sizeof($c_aluno['Estagiario']));
            $cargahorariatotal[$i]['id'] = $c_aluno['Aluno']['id'];
            $cargahorariatotal[$i]['registro'] = $c_aluno['Aluno']['registro'];
            $cargahorariatotal[$i]['q_semestres'] = sizeof($c_aluno['Estagiario']);
            $carga_estagio = NULL;
            $y = 0;
            foreach ($c_aluno['Estagiario'] as $c_estagio):
                // pr($c_estagio);
                if ($c_estagio['nivel'] == 1):
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['ch'];
                // $criterio[$i][$ordem] = $c_estagio['periodo'];
                else:
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['ch'];
                // $criterio[$i][$ordem] = NULL;
                endif;
                $y++;
            endforeach;
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

    public function padroniza() {

        $alunos = $this->Aluno->find('all', array('fields' => array('id', 'nome', 'email', 'endereco', 'bairro')));
        // pr($alunos);
        // die();
        foreach ($alunos as $c_aluno):

            if ($c_aluno['Aluno']['email']):
                $email = strtolower($c_aluno['Aluno']['email']);
                $this->Aluno->query("UPDATE alunos set email = " . "\"" . $email . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno["Aluno"]['nome']):
                $nome = ucwords(strtolower($c_aluno['Aluno']['nome']));
                $this->Aluno->query("UPDATE alunos set nome = " . "\"" . $nome . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno['Aluno']['endereco']):
                $endereco = ucwords(strtolower($c_aluno['Aluno']['endereco']));
                $this->Aluno->query("UPDATE alunos set endereco = " . "\"" . $endereco . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno['Aluno']['bairro']):
                $bairro = ucwords(strtolower($c_aluno['Aluno']['bairro']));
                $this->Aluno->query("UPDATE alunos set bairro = " . "\"" . $bairro . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

        endforeach;
    }

}

?>
