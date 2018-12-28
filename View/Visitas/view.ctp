<?php // pr($visita);    ?>

<h1>Visita institucional: <?php echo $visita['Instituicao']['instituicao']; ?></h1>

<table>
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
    <?php
    echo $this->Html->link('Excluir', '/visitas/excluir/' . $visita['Visita']['id'], NULL, 'Tem certeza?');
    echo " | ";
    echo $this->Html->link('Editar', '/visitas/edit/' . $visita['Visita']['id']);
    ?>
<?php endif; ?>
