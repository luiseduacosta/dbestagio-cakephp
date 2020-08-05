<?php echo $this->element('submenu_instituicoes'); ?>

<?php if (isset($instituicoes)): ?>

    <h5>Resultado da busca de instituições</h5>

    <?php foreach ($instituicoes as $c_instituicao): ?>
        <div class = 'row'>
            <div clas s= 'col'>
                <p><?php echo $this->Html->link($c_instituicao['Instituicao']['instituicao'], '/Instituicoes/view/' . $c_instituicao['Instituicao']['id']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>

<?php else: ?>

    <h5>Busca instituições</h5>

    <?php echo $this->Form->create('Instituicao'); ?>
    <?php echo $this->Form->input('instituicao', array('label' => 'Digite o nome da instituição', 'class' => 'form-control')); ?>
    <br>
    <?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
