<?php

?>

<?php echo $this->Form->create('Estagiario'); ?>
<?php echo $this->Form->input('registro', ['class' => 'form-control']); ?>
<br>
<?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
<?php echo $this->Form->end(); ?>
