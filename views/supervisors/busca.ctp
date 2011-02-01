<?php if (isset($supervisores)): ?>

<h1>Resultado da busca por supervisores</h1>

    <?php $this->Paginator->options(array('url'=>array($busca))); ?>

    <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class'=>'disabled')); ?>
    <?php echo " | "; ?>
    <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class'=>'disabled')); ?>
    <br />
    <?php echo $this->Paginator->numbers(); ?>

    <table>
        <?php foreach ($supervisores as $c_supervisor): ?>
        <tr>
            <td style='text-align:left'><?php echo $html->link($c_supervisor['Supervisor']['nome'],'/Supervisors/view/'.$c_supervisor['Supervisor']['id']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

<h1>Busca supervisores</h1>

    <?php echo $form->create('Supervisor', array('controller'=>'Supervisor','action'=>'busca')); ?>
    <?php echo $form->input('nome',array('label'=>'Digite o nome do supervisor')); ?>
    <?php echo $form->end('Confirma'); ?>

<?php endif; ?>
