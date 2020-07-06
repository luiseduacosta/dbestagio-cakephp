<div class='container'>
    <div class='row'>
        <div class='col-sm-6'>
            <?= $this->Form->create('Userestagio'); ?>

            <div class="form-group">
                <?= $this->Form->input('role', array('label' => 'Selecione', 'options' => array('2' => 'Estudante', '3' => 'Professor', '4' => 'Supervisor'), 'class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->input('numero', ['label' => 'DRE, SIAPE ou CRESS respectivamente', 'class' => 'form-control']); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->submit('Confirma', ['label' => false, 'class' => 'btn btn-primary']); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>