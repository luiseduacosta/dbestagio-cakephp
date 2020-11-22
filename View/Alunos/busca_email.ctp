<?= $this->element('submenu_alunos'); ?>

<?php if (isset($alunos)): ?>

    <h5>Resultado da busca por Email</h5>

    <?php foreach ($alunos as $c_alunos): ?>
        <?php echo $this->Html->link($c_alunos['Aluno']['nome'], '/Alunos/view/' . $c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <h1>Busca por Email</h1>
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
    <?php echo $this->Form->input('email', array('label' => 'Digite o email', 'maxsize' => 70, 'size' => 70)); ?>
    <br>
    <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-success position-static']); ?>    
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
