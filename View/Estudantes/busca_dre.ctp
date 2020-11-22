<?= $this->element('submenu_estudantes'); ?>

<h5>Busca por DRE</h5>

<?php if (isset($estudantes)): ?>

    <?php foreach ($estudantes as $c_alunos): ?>
        <div class="row">
            <div class="col">
                <?php echo $this->Html->link($c_alunos['Estudante']['nome'], '/Estudantes/view/' . $c_alunos['Estudante']['id']) . '<br>'; ?>
            </div>
        </div>
    <?php endforeach; ?>

<?php else: ?>

    <?php echo $this->Form->create('Estudante'); ?>
    <div class="form-group">
        <?php echo $this->Form->input('registro', ['label' => 'Digite o DRE do aluno', 'maxsize' => 9, 'class' => 'form-control']); ?>
    </div>
    <?= $this->Form->input('Confirma', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-success']); ?>
    <?= $this->Form->end(); ?>

<?php endif; ?>
