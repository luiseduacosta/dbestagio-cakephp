<p>
<?php echo $this->Html->link('Inserir aluno','/alunos/add'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por Nome','/alunos/busca'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por DRE','/alunos/busca_dre'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por Email','/alunos/busca_email'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por CPF','/alunos/busca_cpf'); ?>
</p>

<?php 
// pr($alunos); 
// die();
?>
<?php if (isset($alunos)): ?>

<h1>Resultado da busca por nome de estudante</h1>

    <?php $this->Paginator->options(array('url'=>array($nome))); ?>

    <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class'=>'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class'=>'disabled')); ?>

    <table>
        <?php foreach ($alunos as $c_aluno): ?>
        <tr>
            <td style='text-align:left'><?php echo $this->Html->link($c_aluno['Aluno']['nome'],'/alunos/view/'.$c_aluno['Aluno']['id']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

<h1>Busca por nome</h1>

    <?php echo $this->Form->create('Aluno', array('controller'=>'Alunos','url'=>'busca')); ?>
    <?php echo $this->Form->input('nome',array('label'=>'Digite o nome do aluno')); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
