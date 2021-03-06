<?php
// pr($inscritos);
?>
<?php echo $this->Html->link('Listar mural', '/Muralestagios/index'); ?>

<hr />

<h1>
    Estudantes inscritos para seleção de estágio
<?php
if (isset($periodo)) {
    echo " " . $periodo;
};
?>
</h1>

    <?php
    if (isset($instituicao)):
        ?>
    <h1><?php echo $this->Html->link($instituicao . ': ', '/Muralestagios/view/' . $mural_id);
        echo " Vagas: " . $vagas ?></h1>
    <?php echo $this->Html->link($instituicao . ': ', '/Estagiarios/index/instituicao_id:' . $instituicao_id . '/periodo:' . $periodo);
    ;
    echo " Estagiarios: " . $estagiarios; ?>
    <?php
endif;
?>

<?php
if (isset($inscritos)):
    ?>
    <table>
        <thead>
            <tr>
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <th><a href="?ordem=id">Id</a></th>
                    <th><a href="?ordem=id_aluno">DRE</a></th>
                    <th><a href="?ordem=tipo">T</a></th>
                    <th><a href="?ordem=selecao_mural">Estágio</a></th>
                    <th><a href="?ordem=nome">Estudante</a></th>
                    <th><a href="?ordem=nascimento">Nascimento</a></th>
                    <th><a href="?ordem=telefone">Telefone</a></th>
                    <th><a href="?ordem=celular">Celular</a></th>
                    <th><a href="?ordem=email">Email</a></th>
                <?php else: ?>
                    <th><a href="?ordem=nome">Estudante</a></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $registro = NULL;
            foreach ($inscritos as $c_inscrito):
                if ($registro != $c_inscrito['aluno_id']) {
                    $registro = $c_inscrito['aluno_id'];
                    // echo $c_inscrito['nome'] . "<br>";
                    ?>
                    <tr>

                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <td><?php echo $this->Html->link($c_inscrito['inscricao_id'], '/Inscricoes/view/' . $c_inscrito['inscricao_id']); ?></td>
                            <td><?php echo $c_inscrito['aluno_id']; ?></td>
                            <td><?php echo $c_inscrito['tipo']; ?></td>
                            <td>
                                <?php
                                if (isset($c_inscrito['selecao_mural'])) {
                                    echo $c_inscrito['selecao_mural'];
                                }
                                ?>
                            </td>
                        <?php endif; ?>

                        <td>
                            <?php
                            if ($c_inscrito['tipo'] === 0) {
                                if ($this->Session->read('categoria') === 'administrador') {
                                    echo $this->Html->link($c_inscrito['nome'], '/Estudantes/view/' . $c_inscrito['aluno_id']);
                                } else {
                                    echo $c_inscrito['nome'];
                                }
                            } else {
                                if ($this->Session->read('categoria') === 'administrador') {
                                    echo $this->Html->link($c_inscrito['nome'], '/Alunos/view/' . $c_inscrito['id']);
                                } else {
                                    echo $c_inscrito['nome'];
                                }
                            }
                            ?>
                        </td>

                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <td><?php echo $c_inscrito['nascimento']; ?></td>
                            <td><?php echo $c_inscrito['telefone']; ?></td>
                            <td><?php echo $c_inscrito['celular']; ?></td>
                            <td><?php echo $c_inscrito['email']; ?></td>
                        <?php endif; ?>
                    </tr>

                <?php }; ?>

            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
endif;
?>
