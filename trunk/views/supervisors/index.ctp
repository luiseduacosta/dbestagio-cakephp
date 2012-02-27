<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $html->link('Inserir','/Supervisors/add/');
    echo " | ";
    echo $html->link('Buscar','/Supervisors/busca/');
    ?>
    <br />
<?php else: ?>
    <?php
    echo $html->link('Buscar','/Supervisors/busca/');
    ?>
    <br />
<?php endif; ?>

<div align="center">
<?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->prev('< Anterior ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->next(' Posterior > ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->last(' Último >> ', null, null, array('class'=>'disabled')); ?>

<br />

<?php echo $this->Paginator->numbers(); ?>

</div>

<table>

    <thead>
        <tr>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <th>X</th>
            <?php endif; ?>
            <th width='10%'><?php echo $this->Paginator->sort('CRESS', 'Supervisor.cress'); ?></th>
            <th width='90%'><?php echo $this->Paginator->sort('Nome', 'Supervisor.nome'); ?></th>

        </tr>
    </thead>

    <tbody>
        <?php foreach ($supervisores as $c_supervisor): ?>
        <tr>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <td>
                <?php echo $html->link('X', '/Supervisors/delete/'. $c_supervisor['Supervisor']['id'], NULL, 'Confirma?'); ?>
                </td>
            <?php endif; ?>
            <td>
            <?php echo $c_supervisor['Supervisor']['cress']; ?>
            </td>
            <td>
            <?php echo $html->link($c_supervisor['Supervisor']['nome'], '/Supervisors/view/' . $c_supervisor['Supervisor']['id']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
