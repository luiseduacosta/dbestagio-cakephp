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


<?php if (isset($alunos)): ?>

<h1>Resultado da busca por Email</h1>

    <?php foreach ($alunos as $c_alunos): ?>
    <?php echo $html->link($c_alunos['Aluno']['nome'],'/alunos/view/'.$c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

<h1>Busca por Email</h1>

    <?php echo $form->create('Aluno', array('controller'=>'Alunos','action'=>'busca_email')); ?>
    <?php echo $form->input('email', array('label'=>'Digite o email', 'maxsize'=>70, 'size'=>70)); ?>
    <?php echo $form->end('Confirma'); ?>

<?php endif; ?>
