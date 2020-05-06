<?php

class Inscricao extends AppModel {
    /* @var Mural */
    /* @var Aluno */
    /* @var Estudante */
    /* @var Estagiario */

    public $name = 'Inscricao';
    public $useTable = 'muralinscricoes';
    public $primaryKey = 'id';
    public $displayField = 'aluno_id';
    public $belongsTo = array(
        'Mural' => array(
            'className' => 'Muralestagio',
            'foreignKey' => 'mural_estagio_id',
        )
            /*
              'Aluno' => array(
              'className' => 'Aluno',
              'foreignKey' => FALSE,
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


    /*
     * @param $periodo $id (mural_estagio_id)
     * 
     * @return alunosestudantesinscritosperiodoid retorna os inscritos para uma seleção de estagio e um período
     */

    public function alunosestudantesperiodoid($periodo, $id) {

        $alunosestudanatesinscritosperiodoid = $this->query(
                'select * from muralinscricoes as Inscricao '
                . 'INNER JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . 'INNER JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . 'INNER JOIN estagiarios as Estagiario ON Inscricao.aluno_id = Estagiario.registro '
                . 'WHERE Inscricao.periodo = "' . $periodo . '" && Inscricao.mural_estagio_id = ' . $id);

        return $alunosestudanatesinscritosperiodoid;
    }

    /*
     * @param $periodo $id (aluno_id)
     * 
     * @return alunosestudantesinscritosperiodoid retorna os inscritos para uma seleção de estagio e um período
     */

    public function alunosestudantesperiodoregistro($periodo, $id) {

        $alunosestudanatesinscritosperiodoregistro = $this->query(
                'select * from muralinscricoes as Inscricao '
                . 'INNER JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . 'INNER JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . 'INNER JOIN estagiarios as Estagiario ON Inscricao.aluno_id = Estagiario.registro '
                . 'WHERE Inscricao.periodo = "' . $periodo . '" && Inscricao.aluno_id = ' . $id);

        return $alunosestudanatesinscritosperiodoregistro;
    }

    /*
     * Método chamado na classe inscricoes pelo método index
     * @PARAMETRO $id index da tabela muralestagios
     * 
     * @RETURN @alunosestudantesinscritos matriz com os estudantes inscritos para esse mural
     */

    public function alunosestudantesmural($id) {

        $alunosestudanatesinscritos = $this->query(
                'SELECT * FROM muralinscricoes AS Inscricao '
                . ' INNER JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . ' INNER JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . ' WHERE Muralestagio.id = ' . $id
                . ' ORDER BY Estudante.nome');

        return $alunosestudanatesinscritos;
    }

    /*
     * Método chamado na classe inscricoes pelo método index
     * 
     * @PARAMETRO $periodo Período da seleção para estágio
     * 
     * @RETURN $alunosestudanatesinscritosperiodo matriz ordenada com os estudantes inscritos para seleção de estágio no periódo
     */

    public function alunosestudantesperiodo($periodo) {

        $alunosestudanatesinscritosperiodo = $this->query(
                'select * from muralinscricoes as Inscricao '
                . 'INNER JOIN estudantes as Estudante ON Inscricao.aluno_id = Estudante.registro '
                . 'INNER JOIN muralestagios as Muralestagio ON Inscricao.mural_estagio_id = Muralestagio.id '
                . 'WHERE Inscricao.periodo = "' . $periodo . '"'
                . ' ORDER BY Estudante.nome');

        return $alunosestudanatesinscritosperiodo;
    }

}

?>
