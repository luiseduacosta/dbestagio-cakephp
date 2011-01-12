<?php

class InstituicaosController extends AppController {

    var $name = "Instituicaos";

    // var $scaffold;
    // var $helpers = array('Js', array('Jquery'));

    function index($id = NULL) {

        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Instituicao.instituicao' => 'asc')
        );

        $this->set('instituicoes', $this->Paginate('Instituicao'));
    }

    function add($id = NULL) {

        if ($this->data) {
            if ($this->Instituicao->save($this->data)) {
                $this->Session->setFlash('Dados da instituição inseridos!');
                $this->Instituicao->getLastInsertId();
                $this->redirect('/Instituicaos/view/' . $this->Instituicao->getLastInsertId());
            }
        }
    }

    function view($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
                    'conditions' => array('Instituicao.id' => $id),
                    'order' => 'Instituicao.instituicao'));

        // Para acrescentar um supervisor
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', array(
                    'order' => array('Supervisor.nome')));
        $supervisores[0] = '- Seleciona -';
        asort($supervisores);
        $this->set('supervisores', $supervisores);

        // pr($instituicao);

        $proximo = $this->Instituicao->find('neighbors', array(
                    'field' => 'instituicao', 'value' => $instituicao['Instituicao']['instituicao']));

        $this->set('registro_next', $proximo['next']['Instituicao']['id']);
        $this->set('registro_prev', $proximo['prev']['Instituicao']['id']);

        $this->set('instituicao', $instituicao);
    }

    function edit($id = NULL) {
        $this->Instituicao->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Instituicao->read();
        } else {
            if ($this->Instituicao->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Instituicaos/view/' . $id);
            }
        }
    }

    function delete($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
                    'conditions' => array('Instituicao.id' => $id)
                ));

        $murais = $instituicao['Mural'];
        $supervisores = $instituicao['Supervisor'];
        $alunos = $instituicao['Estagiario'];

        if ($murais) {

            $this->Session->setFlash('Há murais vinculados com esta instituição');
            $this->redirect('/Instituicaos/view/' . $id);
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

    function deleteassociacao($id = NULL) {

        $id_superinstituicao = $this->Instituicao->InstSuper->find('first', array('conditions' => 'InstSuper.id = ' . $id));
        // pr($id_superinstituicao);
        // die();

        $this->Instituicao->InstSuper->delete($id);

        $this->Session->setFlash("Supervisor excluido da instituição");
        $this->redirect('/Instituicaos/view/' . $id_superinstituicao['InstSuper']['id_instituicao']);
    }

    function addassociacao($id = NULL) {

        if ($this->data) {
            // pr($this->data);
            // die();
            if ($this->Instituicao->InstSuper->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/Instituicaos/view/' . $this->data['InstSuper']['id_instituicao']);
            }
        }
    }

    function busca($id = NULL) {

        if ($id)
            $this->data['Instituicao']['instituicao'] = $id;

        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Instituicao.instituicao' => 'asc')
        );

        if ($this->data['Instituicao']['instituicao']) {

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

    function seleciona_supervisor($id = NULL) {

        // Configure::write('debug', 0);
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

}

?>
