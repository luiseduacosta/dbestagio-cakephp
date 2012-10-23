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


<?php if (isset($alunos)): ?>

<h1>Resultado da busca por Email</h1>

    <?php foreach ($alunos as $c_alunos): ?>
    <?php echo $this->Html->link($c_alunos['Aluno']['nome'],'/alunos/view/'.$c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

<h1>Busca por Email</h1>

    <?php echo $this->Form->create('Aluno', array('controller'=>'Alunos','action'=>'busca_email')); ?>
    <?php echo $this->Form->input('email', array('label'=>'Digite o email', 'maxsize'=>70, 'size'=>70)); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
