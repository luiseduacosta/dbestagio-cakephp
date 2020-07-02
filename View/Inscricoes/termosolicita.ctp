<h5>Digite o seu número de DRE para solicitar termo de compromisso</h5>

<?= $this->Form->create('Inscricao'); ?>
<?= $this->Form->input('registro', array('placeholder' => 'DRE', 'type' => 'text', 'label' => 'Registro (DRE)', 'size'=> '9', 'maxlength'=>'9', 'default' => $this->Session->read('numero'), 'class' => 'form-control')); ?>
<br>
<?= $this->Form->submit('Confirma', ['class' => 'btn btn-primary']); ?>
<?= $this->Form->end(); ?>
