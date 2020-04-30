<?php

class Inscricao extends AppModel {
    /* @var Mural */
    /* @var Aluno */
    /* @var Estudante */
    /* @var Estagiario */

    public $name = 'Inscricao';
    public $useTable = 'muralinscricoes';
    public $primaryKey = 'id';
    public $belongsTo = array(
        'Mural' => array(
            'className' => 'Muralestagio',
            'foreignKey' => 'mural_estagio_id',
        )
            /*
              'Aluno' => array(
              'className' => 'Aluno',
              'foreignKey' => false,
              'conditions' => ['Inscricao.aluno_id' => 'Aluno.registro']
              ),
              'Estudante' => array(
              'className' => 'Estudante',
              'foreignKey' => FALSE,
              'conditions' => ['Inscricao.aluno_id' => 'Estudante.registro']
              ),

              'Estagiario' => array(
              'className' => 'Estagiario',
              'foreignKey' => FALSE,
              'conditions' => array('Inscricao.aluno_id = Estagiario.registro', 'Inscricao.periodo = Estagiario.periodo')
              )
             */
    );

    public function alunosinscritosaluno_id($id) {

        $alunosinscritos = $this->query('select * from muralinscricoes as Inscricao '
                . 'LEFT JOIN alunos as Aluno ON Inscricao.aluno_id = Aluno.registro '
                . 'WHERE Inscricao.aluno_id = ' . $id);

        return $alunosinscritos;
    }

    public function alunosinscritosbyId($id) {

        $alunosinscritosbyId = $this->query('select * from muralinscricoes as Inscricao '
                . 'LEFT JOIN alunos as Aluno ON Inscricao.aluno_id = Aluno.registro '
                . 'WHERE Inscricao.id = ' . $id);

        return $alunosinscritosbyId;
    }

    
    /*
     * Alunosestudantesinscritos Method (para método view)
     * 
     * @param $id muralinscricoes
     * 
     * @return $alunosestudantesinscritos para seleção de estágio no mural
     */
    public function alunosestudantesinscritos($id) {

        $alunosestudanatesinscritos = $this->query(
                'select * from muralinscricoes as Inscricao '
                . 'LEFT JOIN alunos as Aluno ON Inscricao.aluno_id = Aluno.registro '
                . 'LEFT JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . 'LEFT JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . 'LEFT JOIN estagiarios as Estagiario ON Inscricao.aluno_id = Estagiario.registro '
                . ' WHERE Inscricao.id = ' . $id
                . ' LIMIT 1');

        return $alunosestudanatesinscritos;
    }
    
    /*
     * Alunosestudantesmural Method (para método index)
     * 
     * @param $id muralestagio
     * 
     * @return $alunosestudantesinscritos para seleção de estágio no muralestagio $id
     */
    public function alunosestudantesmural($id) {

        $alunosestudanatesinscritos = $this->query(
                'select * from muralinscricoes as Inscricao '
                . 'LEFT JOIN alunos as Aluno ON Inscricao.aluno_id = Aluno.registro '
                . 'LEFT JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . 'LEFT JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . 'LEFT JOIN estagiarios as Estagiario ON Inscricao.aluno_id = Estagiario.registro '
                . 'WHERE Muralestagio.id = ' . $id);

        return $alunosestudanatesinscritos;
    }

    /*
     * @param $periodo $id
     * 
     * @return alunosestudantesinscritosperiodoid retorna os inscritos para uma seleção de estagio e um período
     */
    public function alunosestudantesperiodoid($periodo, $id) {

        $alunosestudanatesinscritosperiodoid = $this->query(
                'select * from muralinscricoes as Inscricao '
                . 'LEFT JOIN alunos as Aluno ON Inscricao.aluno_id = Aluno.registro '
                . 'LEFT JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . 'LEFT JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . 'LEFT JOIN estagiarios as Estagiario ON Inscricao.aluno_id = Estagiario.registro '
                . 'WHERE Inscricao.periodo = "' . $periodo . '" && Inscricao.mural_estagio_id = ' . $id);

        return $alunosestudanatesinscritosperiodoid;
    }

    public function alunosestudantesperiodo($periodo) {

        $alunosestudanatesinscritosperiodo = $this->query(
                'select * from muralinscricoes as Inscricao '
                . 'LEFT JOIN alunos as Aluno ON Inscricao.aluno_id = Aluno.registro '
                . 'LEFT JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . 'LEFT JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . 'LEFT JOIN estagiarios as Estagiario ON Inscricao.aluno_id = Estagiario.registro '
                . 'WHERE Inscricao.periodo = "' . $periodo . '"');

        return $alunosestudanatesinscritosperiodo;
    }

}

?>
