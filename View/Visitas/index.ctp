<?php // pr($visitas);   ?>

<?php echo $this->element('submenu_visitas'); ?>

<div align="center">
    <?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->prev('< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->next(' Posterior > ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

    <br />

    <?php echo $this->Paginator->numbers(); ?>

</div>

<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">

        <thead class="thead-light">
            <tr>
                <th><?php echo $this->Paginator->sort('Visita.id', 'Id'); ?></th>
                <th><?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?></th>
                <th><?php echo $this->Paginator->sort('Visita.data', 'Visita'); ?></th>
                <th><?php echo $this->Paginator->sort('Visita.responsavel', 'Responsável'); ?></th>
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <th><?php echo $this->Paginator->sort('Visita.motivo', 'Motivo'); ?></th>
                    <th><?php echo $this->Paginator->sort('Visita.avaliacao', 'Avaliação'); ?></th>
                <?php endif; ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($visitas as $c_visita): ?>
                <?php // pr($c_visita); ?>
                <tr>
                    <td>
                        <?php echo $this->Html->link($c_visita['Visita']['id'], 'view/' . $c_visita['Visita']['id']); ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Html->link($c_visita['Instituicao']['instituicao'], '/Instituicoes/view/' . $c_visita['Instituicao']['id']);
                        ?>
                    </td>
                    <td>
                        <?php echo date('d-m-Y', strtotime($c_visita['Visita']['data'])); ?>
                    </td>
                    <td>
                        <?php echo $c_visita['Visita']['responsavel']; ?>
                    </td>
                    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                        <td>
                            <?php echo $c_visita['Visita']['motivo']; ?>
                        </td>
                        <td>
                            <?php echo $c_visita['Visita']['avaliacao']; ?>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>