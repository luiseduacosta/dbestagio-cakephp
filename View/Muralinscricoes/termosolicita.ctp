<h5>DRE para solicitar termo de compromisso</h5>

<?= $this->Form->create('Muralinscricao'); ?>
<?php if ($this->Session->read('id_categoria') == '1'): ?>
    <?= $this->Form->input('registro', array('placeholder' => 'DRE', 'type' => 'text', 'label' => 'Registro (DRE)', 'size' => '9', 'maxlength' => '9', 'default' => $this->Session->read('numero'), 'required', 'class' => 'form-control')); ?>
<?php elseif ($this->Session->read('id_categoria') == '2'): ?>
    <?= $this->Form->input('registro', array('placeholder' => 'DRE', 'type' => 'text', 'label' => 'Registro (DRE)', 'size' => '9', 'maxlength' => '9', 'readonly' => 'readonly', 'default' => $this->Session->read('numero'), 'class' => 'form-control')); ?>
<?php endif; ?>
<br>
<?= $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
<?= $this->Form->end(); ?>
