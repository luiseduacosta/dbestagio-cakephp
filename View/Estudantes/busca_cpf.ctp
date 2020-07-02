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

    <h5>Busca por CPF</h5>
    <?php echo $this->Form->create("Estudante"); ?>
    <div class="form-group">
        <?php echo $this->Form->input('cpf', array('label' => 'Digite o CPF', 'placeholder' => '000000000-00', 'maxsize' => 12, 'size' => 12, 'class' => 'form-control')); ?>
    </div>
    <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-primary position-static']); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
