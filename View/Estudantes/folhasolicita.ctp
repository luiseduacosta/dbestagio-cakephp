<?= $this->element('submenu_estudantes'); ?>
<br>
<?php
echo $this->Form->create('Estudante');
echo $this->Form->input('DRE', ['label' => "DRE", 'class' => 'form-control']);
?>
<br>
<?php
echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit' ,'class' => 'btn btn-success position-static']);
echo $this->Form->end();
?>
