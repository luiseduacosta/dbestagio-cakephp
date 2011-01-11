<p>
<?php echo $html->link('Inserir aluno','/alunos/add'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Busca por Nome','/alunos/busca'); ?> 
<?php echo " | "; ?>
<?php echo $html->link('Busca por DRE','/alunos/busca_dre'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Busca por Email','/alunos/busca_email'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Busca por CPF','/alunos/busca_cpf'); ?>
</p>

<h1>Busca por CPF</h1>

<?php if (isset($alunos)): ?>

    <?php foreach ($alunos as $c_alunos): ?>
    <?php echo $html->link($c_alunos['Aluno']['nome'],'/alunos/view/'.$c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <?php echo $form->create('Aluno', array('controller'=>'Alunos','action'=>'busca_cpf')); ?>
    <?php echo $form->input('cpf', array('label'=>'Digite o CPF', 'maxsize'=>12, 'size'=>12)); ?>
    <?php echo $form->end('Confirma'); ?>

<?php endif; ?>
