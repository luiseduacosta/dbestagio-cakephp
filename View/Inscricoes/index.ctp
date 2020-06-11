<?php
// pr($inscritos);
?>

<?= $this->element('submenu_muralestagios'); ?>

<h1>
    Estudantes inscritos para seleção de estágio em
    <?php
    if (isset($periodo)) {
        echo " " . $periodo;
    };
    ?>
</h1>

<?php if (isset($instituicao)): ?>
    <h1>
        <?= $this->Html->link("Mural: " . $instituicao, '/Muralestagios/view/' . $mural_estagio_id) . ": Vagas: " . $vagas ?>
    </h1>
    <h1>
        <?= $this->Html->link("Estagiários: " . $instituicao, '/Estagiarios/index/instituicao_id:' . $instituicao_id . '/periodo:' . $periodo) ?>
    </h1>
<?php endif; ?>
<h1>São <?= $estudantetipos[0] = isset($estudantetipos[0]) ? $estudantetipos[0] : 0 ?> inscrições de estudantes novos e <?= $estudantetipos[1] ?> de estagiários</h1>
<?php
if (isset($inscritos)):
    ?>
    <div class='table-responsive'>
        <table class="table table-striped table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                        <th><a href="?ordem=inscricao_id">Id</a></th>
                        <th><a href="?ordem=estudante_id">DRE</a></th>
                        <th><a href="?ordem=tipo">T</a></th>
                        <th>Estágio</a></th>
                        <th><a href="?ordem=nome">Estudante</a></th>
                        <th><a href="?ordem=q_inscricoes">Inscrições</a></th>
                        <th><a href="?ordem=nascimento">Nascimento</a></th>
                        <th><a href="?ordem=telefone">Telefone</a></th>
                        <th><a href="?ordem=celular">Celular</a></th>
                        <th><a href="?ordem=email">Email</a></th>
                    <?php else: ?>
                        <th><a href="?ordem=nome">Estudante</a></th>
                        <th><a href="?ordem=q_inscricoes">Inscrições</a></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $registro = NULL;
                foreach ($inscritos as $c_inscrito):
                    ?>
                    <tr>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <td><?php echo $this->Html->link($c_inscrito['inscricao_id'], '/Inscricoes/view/' . $c_inscrito['inscricao_id']); ?></td>
                            <td><?php echo $c_inscrito['registro']; ?></td>
                            <td><?php echo $c_inscrito['tipo']; ?></td>
                            <td>
                                <?php
                                if (isset($c_inscrito['selecao_mural'])) {
                                    echo $c_inscrito['selecao_mural'];
                                }
                                ?>
                            </td>
                            <td>
                                <?= $this->Html->link($c_inscrito['nome'], '/Estudantes/view/' . $c_inscrito['registro']) ?>
                            </td>
                            <td><?php echo $c_inscrito['q_inscricoes']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($c_inscrito['nascimento'])); ?></td>
                            <td><?php echo $c_inscrito['telefone']; ?></td>
                            <td><?php echo $c_inscrito['celular']; ?></td>
                            <td><?php echo $c_inscrito['email']; ?></td>

                        <?php else: ?>

                            <td><?php echo $c_inscrito['nome']; ?></td>
                            <td><?php echo $c_inscrito['q_inscricoes']; ?></td>

                        <?php endif; ?>
                    </tr>

                <?php endforeach; ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
    <?php
endif;
?>
