<?= $this->element('submenu_estudantes'); ?>

<?php if (isset($estudantes)): ?>

    <h5>Resultado da busca por CPF</h5>

    <?php foreach ($estudantes as $c_alunos): ?>
        <div class="row">
            <div class="col">
                <?php echo $this->Html->link($c_alunos['Estudante']['nome'], '/Estudantes/view/' . $c_alunos['Estudante']['id']) . '<br>'; ?>
            </div>
        </div>
    <?php endforeach; ?>

<?php else: ?>
    <div class="container">
        <h5>Busca por CPF</h5>
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
        <?php echo $this->Form->input('cpf', array('label' => 'Digite o CPF', 'placeholder' => '000000000-00', 'maxsize' => 12, 'size' => 12, 'class' => 'form-control')); ?>
        <br>
        <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-primary position-static']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
<?php endif; ?>
