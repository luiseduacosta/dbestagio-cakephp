<?= $this->element('submenu_alunos'); ?>

<?php if (isset($alunos)): ?>

<h5>Resultado da busca por DRE</h5>

    <?php foreach ($alunos as $c_alunos): ?>
        <?php if (isset($c_alunos['Aluno']['nome'])): ?>
            <?php echo $this->Html->link($c_alunos['Aluno']['nome'], '/Alunos/view/' . $c_alunos['Aluno']['id']) . '<br>'; ?>
        <?php else: ?>
            <?php echo $this->Html->link($c_alunos['Alunonovo']['nome'], '/Estudantes/view/' . $c_alunos['Alunonovo']['id']) . '<br>'; ?>
        <?php endif; ?>    
    <?php endforeach; ?>

<?php else: ?>

    <h5>Busca por DRE</h5>
    <br>
    <?php
    echo $this->Form->create("Aluno", ['inputDefaults' => [
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-lg-3 col-form-label'],
            'between' => '<div class = "col-lg-9">',
            'after' => '</div>',
            'class' => 'form-control']
    ]);
    ?>
    <?php echo $this->Form->input('registro', array('label' => 'Digite o DRE do aluno', 'maxsize' => 9)); ?>
    <br>
    <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-success position-static']); ?>
   <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
