<h1>Busca por DRE</h1>

<?php if (isset($alunonovos)): ?>

    <?php foreach ($alunonovos as $c_alunos): ?>
    <?php echo $html->link($c_alunos['Alunonovo']['nome'],'/alunonovos/view/'.$c_alunos['Alunonovo']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <?php echo $form->create('Alunonovo', array('controller'=>'Alunonovos','action'=>'busca_dre')); ?>
    <?php echo $form->input('registro', array('label'=>'Digite o DRE do aluno', 'maxsize'=>9)); ?>
    <?php echo $form->end('Confirma'); ?>

<?php endif; ?>
