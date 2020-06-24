<?= $this->element('submenu_estudantes'); ?>

<?php if (isset($estudantes)): ?>

    <h5>Resultado da busca por Email</h5>

    <?php foreach ($estudantes as $c_alunos): ?>
        <?php echo $this->Html->link($c_alunos['Estudante']['nome'], '/Estudantes/view/' . $c_alunos['Estudante']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <h5>Busca por Email</h5>
    <br>
    <?php
    echo $this->Form->create("Estudante", ['inputDefaults' => [
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-lg-3 col-form-label'],
            'between' => '<div class = "col-lg-9">',
            'after' => '</div>',
            'class' => 'form-control']
    ]);
    ?>
    <?php echo $this->Form->input('email', array('label' => 'Digite o email', 'maxsize' => 70, 'size' => 70)); ?>
    <br>
    <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-primary position-static']); ?>    
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
