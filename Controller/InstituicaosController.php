<?php

class InstituicaosController extends AppController {

    public $name = "Instituicaos";
    public $components = array('Auth', 'Paginator');
    public $helpers = array('Paginator');

    public function beforeFilter() {

        parent::beforeFilter();
// Admin
        if ($this->Session->read('id_categoria') === '1') {
            $this->Auth->allow();
// $this->Session->setFlash("Administrador");
// Estudantes
        } elseif ($this->Session->read('id_categoria') === '2') {
            $this->Auth->allow('index', 'view', 'busca');
// $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') === '3') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca');
// $this->Session->setFlash("Professor");
// Professores, Supervisores
        } elseif ($this->Session->read('id_cateogria') === '4') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'view', 'busca');
// $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Session->setFlash("Não autorizado");
            $this->redirect('/users/login/');
        }
    }

    public function index() {

        $parametros = $this->params['named'];
// pr($parametros);
        $area_instituicao_id = isset($parametros['area_instituicoes_id']) ? $parametros['area_instituicoes_id'] : NULL;
// print_r($area_instituicao_id);
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : NULL;
// print_r($natureza);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        print_r($periodo);
        $limite = isset($parametros['limite']) ? $parametros['limite'] : 25;
// print_r($limite);
        $visita = isset($parametros['visita']) ? $parametros['visita'] : NULL;
// print_r($visita);

        $ordem = $this->params['named'];

        $todosPeriodos = $this->Instituicao->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));

        // Capturo o periodo atual 
        $periodo_atual = $this->Instituicao->Estagiario->find('all', array(
            'fields' => 'MAX(Estagiario.periodo) as periodo')
        );
        foreach ($periodo_atual as $c_periodo_atual) {
            // pr($c_periodo_atual);
            foreach ($c_periodo_atual as $periodo_hoje) {
                // pr($periodo);
            }
        }
        $atual_periodo = $periodo_hoje['periodo'];
        // pr($atual_periodo);

        if (empty($periodo)) {
            $periodo = $atual_periodo;
        }

        $options = array(
            'joins' =>
            array(
                array(
                    'table' => 'estagiarios',
                    'alias' => 'Estagiario',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('Instituicao.id = Estagiario.id_instituicao'))
            )
        );
        
        $this->loadModel('Estagiario');
        $instituicaoes_prova = $this->Estagiario->find('first', array(
            'contain' => array('Supervisor', 'Instituicao', 'Visita')
        ));
        
 /*       
        $this->recursive = -1;
        $instituicaoes_prova = $this->Instituicao->find('first', $options, array(
            'contain' => array('Estagiario', array(
            'fields' => array(
                'Instituicao.instituicao',
                'count(Distinct Estagiario.id_supervisor) as supervisores',
                'count(Distinct Estagiario.id_aluno) as alunos'),
            'Group by => Estagiario.id_instituicao'),
                'Visita'),
            'limit' => 10)
        );
*/
        $log = $this->Estagiario->getDataSource()->getLog(false, false);
        debug($log);

        pr($instituicaoes_prova);
        die();
        /*
          $instituicoes = $this->Instituicao->Estagiario->find('all', array(
          'fields' => array('Estagiario.periodo',
          'Estagiario.id_instituicao',
          'Estagiario.id_supervisor',
          'Instituicao.instituicao',
          'Instituicao.expira'),
          'conditions' => array('Estagiario.periodo' => $periodo)
          )
          );
         */

        // $log = $this->Instituicao->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($instituicoes);
        // die();

        $this->Paginator->settings = array(
            'contain' => array(
                'Estagiario.periodo', 'Estagiario.id_supervisor', 'Estagiario.registro',
                'Visita.data'),
            'limit' => $limite)
        ;

        $this->Paginator->settings = array(
            'contain' => array(
                'Estagiario.periodo = ' . $periodo,
                'Estagiario.id_supervisor',
                'Estagiario.registro',
                'Visita.data'),
            'limit' => $limite)
        ;

        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        $this->set('limite', $limite);
// $this->set('instituicoes', $this->Paginate($instituicoes_total));
        $this->set('instituicoes', $this->Paginator->paginate('Instituicao'));
    }

    public function add() {

        $area_instituicao = $this->Instituicao->AreaInstituicao->find('list', array(
            'order' => 'AreaInstituicao.area'));
// pr($area_instituicao);
// die();
        $this->set('id_area_instituicao', $area_instituicao);

        if ($this->data) {
            if ($this->Instituicao->save($this->data)) {
                $this->Session->setFlash('Dados da instituição inseridos!');
                $this->Instituicao->getLastInsertId();
                $this->redirect('/Instituicaos/view/' . $this->Instituicao->getLastInsertId());
            }
        }
    }

    public function view($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
            'conditions' => array('Instituicao.id' => $id),
            'order' => 'Instituicao.instituicao'));
// pr($instituicao);

        /* Para acrescentar um supervisor */
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', array(
            'order' => array('Supervisor.nome')));

        $this->set('supervisores', $supervisores);

        $proximo = $this->Instituicao->find('neighbors', array(
            'field' => 'instituicao', 'value' => $instituicao['Instituicao']['instituicao']));

        $this->set('registro_next', $proximo['next']['Instituicao']['id']);
        $this->set('registro_prev', $proximo['prev']['Instituicao']['id']);

        $this->set('instituicao', $instituicao);
    }

    public function edit($id = NULL) {

        $this->Instituicao->id = $id;

        $area_instituicao = $this->Instituicao->AreaInstituicao->find('list', array(
            'order' => 'AreaInstituicao.area'
        ));

        $this->set('area_instituicao', $area_instituicao);

        if (empty($this->data)) {
            $this->data = $this->Instituicao->read();
        } else {
            if ($this->Instituicao->save($this->data)) {
// print_r($id);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Instituicaos/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
            'conditions' => array('Instituicao.id' => $id)
        ));

        $murais = $instituicao['Mural'];
        $supervisores = $instituicao['Supervisor'];
        $alunos = $instituicao['Estagiario'];

        if ($murais) {
// die(pr($murais[0]['id']));

            $this->Session->setFlash('Há murais vinculados com esta instituição');
            $this->redirect('/Murals/view/' . $murais[0]['id']);
        } elseif ($supervisores) {

            $this->Session->setFlash('Há supervisores vinculados com esta instituição');
            $this->redirect('/Instituicaos/view/' . $id);
        } elseif ($alunos) {

            $this->Session->setFlash('Há alunos estagiários vinculados com esta instituição');
            $this->redirect('/Instituicaos/view/' . $id);
        } else {
            $this->Instituicao->delete($id);
            $this->Session->setFlash('Registro excluído');
            $this->redirect('/Instituicaos/index/');
        }
    }

    public function deleteassociacao($id = NULL) {

        $id_superinstituicao = $this->Instituicao->InstSuper->find('first', array('conditions' => 'InstSuper.id = ' . $id));
// pr($id_superinstituicao);
// die();

        $this->Instituicao->InstSuper->delete($id);

        $this->Session->setFlash("Supervisor excluido da instituição");
        $this->redirect('/Instituicaos/view/' . $id_superinstituicao['InstSuper']['id_instituicao']);
    }

    public function addassociacao() {

        if ($this->data) {
// pr($this->data);
// die();
            if ($this->Instituicao->InstSuper->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/Instituicaos/view/' . $this->data['InstSuper']['id_instituicao']);
            }
        }
    }

    public function busca($id = NULL) {

        if ($id)
            $this->request->data['Instituicao']['instituicao'] = $id;

        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Instituicao.instituicao' => 'asc')
        );

        if ($this->request->data['Instituicao']['instituicao']) {

            $condicao = array('Instituicao.instituicao like' => '%' . $this->data['Instituicao']['instituicao'] . '%');
            $instituicoes = $this->Instituicao->find('all', array('conditions' => $condicao));

// Nenhum resultado
            if (empty($instituicoes)) {
                $this->Session->setFlash("Não foram encontrados registros");
            } else {
                $this->set('instituicoes', $this->Paginate($condicao));
                $this->set('busca', $this->data['Instituicao']['instituicao']);
            }
        }
    }

    /*
     * Seleciona supervisor em funcao da selecao da instituicao
     */

    public function seleciona_supervisor($id = NULL) {

// Configure::write('debug', 2);
        if ($id != 0) {
            $supervisores = $this->Instituicao->find('all', array(
                'conditions' => array('Instituicao.id = ' . $id)
                    )
            );

            if ($supervisores) {
                $i = 0;
                foreach ($supervisores as $c_supervisor) {
// pr($c_supervisor['Supervisor']);
                    foreach ($c_supervisor['Supervisor'] as $cada_supervisor) {
                        $super[$i]['nome'] = $cada_supervisor['nome'];
                        $super[$i]['id'] = $cada_supervisor['id'];
                        $i++;
                    }
// die();
                }

// Pode ser que nao tenha supervisores
                if (isset($super)) {
                    asort($super);
                    $this->set('supervisores', $super);
                }
// pr($super);
                $this->set('id', $id);
            } else {
                $this->Sesion->setFlash("Sem supervisores cadastrados");
            }

            /*
             * Poderia tambem capturar o professor e a area da instituicao
             * Para isto consulto a tabela estagiarios
             * A area e o professor poderiam ser passados atraves de um cooke
             */
            $this->loadModel('Estagiario');
            $prof_area = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.id_instituicao =' . $id),
                'fields' => array('Estagiario.id_supervisor', 'Estagiario.id_professor', 'Estagiario.id_area', 'Estagiario.periodo'),
                'order' => array('Estagiario.periodo DESC')
            ));
// pr($prof_area);

            $id_area = $prof_area['Estagiario']['id_area'];
            $id_prof = $prof_area['Estagiario']['id_professor'];

// $id_area = $this->Estagiario->find('all');
            $this->Session->delete('id_area', $id_area);
            $this->Session->delete('id_prof', $id_prof);
            $this->Session->write('id_area', $id_area);
            $this->Session->write('id_prof', $id_prof);
        } else {

            $this->Sesion->setFlash("Selecione uma instituição");
            $this->redirect('/Inscricaos/termocompromisso/' . $id);
        }
    }

    public function natureza() {

        $this->Instituicao->virtualFields['qnatureza'] = 'count(natureza)';

        $natureza = $this->Instituicao->find('all', array(
            'fields' => array('natureza', 'count(natureza) as Instituicao__qnatureza'),
            'group' => array('natureza')
                )
        );

        $this->set('natureza', $natureza);
    }

    public function listainstituicao() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.instituicao'),
                'conditions' => array('Instituicao.instituicao LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.instituicao')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['instituicao'] . "\n";
            }
        }
    }

    public function listanatureza() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.natureza'),
                'conditions' => array('Instituicao.natureza LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.natureza')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['natureza'] . "\n";
            }
        }
    }

    public function listabairro() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.bairro'),
                'conditions' => array('Instituicao.bairro LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.bairro')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['bairro'] . "\n";
            }
        }
    }

}

?>
