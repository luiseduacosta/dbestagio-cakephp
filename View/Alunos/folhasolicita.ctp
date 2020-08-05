<?= $this->element('submenu_alunos'); ?>
<br>
<?php
echo $this->Form->create('Aluno');
echo $this->Form->input('DRE', ['label' => "DRE", 'class' => 'form-control']);
?>
<br>
<?php
echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit' ,'class' => 'btn btn-success position-static']);
echo $this->Form->end();
?>
