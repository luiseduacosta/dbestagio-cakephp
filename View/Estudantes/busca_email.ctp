<?= $this->element('submenu_estudantes'); ?>

<?php if (isset($estudantes)): ?>

    <h5>Resultado da busca por Email</h5>

    <?php foreach ($estudantes as $c_alunos): ?>
        <?php echo $this->Html->link($c_alunos['Estudante']['nome'], '/Estudantes/view/' . $c_alunos['Estudante']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <h5>Busca por Email</h5>
    <?php
    echo $this->Form->create("Estudante"); ?>
    <div class="form-group">
        <?php echo $this->Form->input('email', array('label' => 'Digite o email', 'maxsize' => 70, 'size' => 70, 'class' => 'form-control')); ?>
    </div>   
    <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-success position-static']); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
