<?php

class Muralinscricao extends AppModel {
    /* @var Mural */
    /* @var Aluno */
    /* @var Estudante */
    /* @var Estagiario */

    public $name = 'Muralinscricao';
    public $useTable = 'muralinscricoes';
    public $primaryKey = 'id';
    public $displayField = 'registro';
    public $actsAs = array('Containable');    
    public $belongsTo = array(
        'Muralestagio' => array(
            'className' => 'Muralestagio',
            'foreignKey' => 'muralestagio_id',
        ),
        'Estudante' => array(
            'className' => 'Estudante',
            'foreignKey' => 'estudante_id'
        )
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
                'select * from muralinscricoes as Muralinscricao '
                . 'LEFT JOIN estudantes as Estudante ON Muralinscricao.estudante_id = Estudante.id '
                . 'LEFT JOIN muralestagios as Muralestagio ON Muralinscricao.muralestagio_id = Muralestagio.id '
                . 'LEFT JOIN estagiarios as Estagiario ON Muralinscricao.estudante_id = Estagiario.estudante_id '
                . ' WHERE Muralinscricao.id = ' . $id
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
     * @param $periodo $id (muralestagio_id)
     * 
     * @return alunosestudantesinscritosperiodoid retorna os inscritos para uma seleção de estagio e um período
     */

    public function alunosestudantesperiodoid($periodo, $id) {

        $alunosestudanatesinscritosperiodoid = $this->query(
                'select * from muralinscricoes as Muralinscricao '
                . 'INNER JOIN estudantes as Estudante ON Muralinscricao.estudante_id = Estudante.id '
                . 'INNER JOIN muralestagios as Muralestagio ON Muralinscricao.muralestagio_id = Muralestagio.id '
                . 'INNER JOIN estagiarios as Estagiario ON Muralinscricao.estudante_id = Estagiario.estudante_id '
                . 'WHERE Muralinscricao.periodo = "' . $periodo . '" && Muralinscricao.muralestagio_id = ' . $id);

        return $alunosestudanatesinscritosperiodoid;
    }

    /*
     * @param $periodo $id (aluno_id)
     * 
     * @return alunosestudantesinscritosperiodoid retorna os inscritos para uma seleção de estagio e um período
     */

    public function alunosestudantesperiodoregistro($periodo, $id) {

        $alunosestudanatesinscritosperiodoregistro = $this->query(
                'select * from muralinscricoes as Muralinscricao '
                . 'INNER JOIN estudantes as Estudante ON Muralinscricao.estudante_id = Estudante.id '
                . 'INNER JOIN muralestagios as Muralestagio ON Muralinscricao.muralestagio_id = Muralestagio.id '
                . 'INNER JOIN estagiarios as Estagiario ON Muralinscricao.estudante_id = Estagiario.estudante_id '
                . 'WHERE Muralinscricao.periodo = "' . $periodo . '" && Muralinscricao.registro = ' . $id);

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
                'SELECT * FROM muralinscricoes AS Muralinscricao '
                . ' INNER JOIN estudantes as Estudante ON Muralinscricao.estudante_id = Estudante.id '
                . ' INNER JOIN muralestagios as Muralestagio ON Muralinscricao.muralestagio_id = Muralestagio.id '
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
                'select * from muralinscricoes as Muralinscricao '
                . 'INNER JOIN estudantes as Estudante ON Muralinscricao.estudante_id = Estudante.id '
                . 'INNER JOIN muralestagios as Muralestagio ON Muralinscricao.muralestagio_id = Muralestagio.id '
                . 'WHERE Muralinscricao.periodo = "' . $periodo . '"'
                . ' ORDER BY Estudante.nome');

        return $alunosestudanatesinscritosperiodo;
    }

}

?>
