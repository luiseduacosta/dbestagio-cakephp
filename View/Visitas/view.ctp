<?php // pr($visita);     ?>

<?php echo $this->element('submenu_visitas'); ?>

<h5>Visita institucional: <?php echo $visita['Instituicaoestagio']['instituicao']; ?></h5>

<table class="table table-striped table-hover table-responsive">
    <tbody>
        <tr>
            <td>Id</td>
            <td>
                <?php echo $visita['Visita']['id']; ?>
            </td>
        </tr>

        <tr>
            <td>Data</td>
            <td>
                <?php echo date('d-m-Y', strtotime($visita['Visita']['data'])); ?>
            </td>
        </tr>

        <tr>
            <td>Motivo</td>
            <td>
                <?php echo $visita['Visita']['motivo']; ?>
            </td>
        </tr>
        <tr>
            <td>Responsável</td>
            <td>
                <?php echo $visita['Visita']['responsavel']; ?>
            </td>
        </tr>

        <?php if ($this->Session->read('categoria') === 'administrador' || $this->Session->read('categoria') === 'professor'): ?>

            <tr>
                <td>Descrição</td>
                <td>
                    <?php echo $visita['Visita']['descricao']; ?>
                </td>
            </tr>

            <tr>
                <td>Avaliação</td>
                <td>
                    <?php echo $visita['Visita']['avaliacao']; ?>
                </td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <nav class="nav nav-tabs">
        <?= $this->Html->link('Excluir', '/visitas/excluir/' . $visita['Visita']['id'], ['class' => 'nav-item nav-link'], 'Tem certeza?'); ?>
        <?= $this->Html->link('Editar', '/visitas/edit/' . $visita['Visita']['id'], ['class' => 'nav-item nav-link']); ?>
    </nav>
<?php endif; ?>
