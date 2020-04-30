
<?php if (isset($instituicoes)): ?>

<h1>Resultado da busca de instituições</h1>

    <?php $this->Paginator->options(array('url'=>array($busca))); ?>

    <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class'=>'disabled')); ?>
    <?php echo " | "; ?>
    <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class'=>'disabled')); ?>
    <br />
    <?php echo $this->Paginator->numbers(); ?>

    <table>
        <?php foreach ($instituicoes as $c_instituicao): ?>
        <tr>
            <td style='text-align:left'><?php echo $this->Html->link($c_instituicao['Instituicao']['instituicao'],'/Instituicoes/view/'.$c_instituicao['Instituicao']['id']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

<h1>Busca instituições</h1>

    <?php echo $this->Form->create('Instituicao', array('controller'=>'Instituicao','url'=>'busca')); ?>
    <?php echo $this->Form->input('instituicao',array('label'=>'Digite o nome da instituição')); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
