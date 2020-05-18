<h1>Busca por DRE</h1>

<?php if (isset($alunonovos)): ?>

    <?php foreach ($alunonovos as $c_alunos): ?>
    <?php echo $this->Html->link($c_alunos['Estudante']['nome'],'/Estudantes/view/'.$c_alunos['Estudante']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <?php echo $this->Form->create('Estudante', array('controller'=>'Estudantes', 'action'=>'busca_dre')); ?>
    <?php echo $this->Form->input('registro', array('label'=>'Digite o DRE do aluno', 'maxsize'=>9)); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
