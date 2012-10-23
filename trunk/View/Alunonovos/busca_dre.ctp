<h1>Busca por DRE</h1>

<?php if (isset($alunonovos)): ?>

    <?php foreach ($alunonovos as $c_alunos): ?>
    <?php echo $this->Html->link($c_alunos['Alunonovo']['nome'],'/alunonovos/view/'.$c_alunos['Alunonovo']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <?php echo $this->Form->create('Alunonovo', array('controller'=>'Alunonovos','action'=>'busca_dre')); ?>
    <?php echo $this->Form->input('registro', array('label'=>'Digite o DRE do aluno', 'maxsize'=>9)); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
