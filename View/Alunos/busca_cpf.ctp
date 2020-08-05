<?= $this->element('submenu_alunos'); ?>

<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por CPF</h1>

    <?php foreach ($alunos as $c_alunos): ?>
        <?php echo $this->Html->link($c_alunos['Aluno']['nome'], '/alunos/view/' . $c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>
    <div class="container">
        <h5>Busca por CPF</h5>
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
        <?php echo $this->Form->input('cpf', array('label' => 'Digite o CPF', 'placeholder' => '000000000-00', 'maxsize' => 12, 'size' => 12, 'class' => 'form-control')); ?>
        <br>
        <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-success position-static']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
<?php endif; ?>
