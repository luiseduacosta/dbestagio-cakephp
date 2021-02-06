<?= $this->element('submenu_estudantes'); ?>
<br>
<?php
echo $this->Form->create('Estudante');
if ($this->Session->read('id_categoria') == '1'):
    echo $this->Form->input('DRE', ['placeholder' => 'DRE', 'label' => "DRE", 'required', 'class' => 'form-control']);
elseif ($this->Session->read('id_categoria') == '2'):
    echo $this->Form->input('DRE', ['label' => "DRE", 'readonly' => 'readonly', 'class' => 'form-control']);
    ?>
    <?php
endif;
?>
<br>
<?php
echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-success position-static']);
echo $this->Form->end();
?>
