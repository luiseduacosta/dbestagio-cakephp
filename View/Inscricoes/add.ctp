<?php 

?>

<h5>Digite o número de DRE</h5>

<?php echo $this->Form->create('Inscricao'); ?>
<?php $numero = $this->Session->read('numero'); ?>
<?php if ($this->Session->read('id_categoria') == 2): ?>
    <?php echo $this->Form->input('registro', array('type' => 'text', 'label' => 'Registro (DRE)', 'size' => 9, 'maxlenght' => 9, 'value' => $this->Session->read('numero'), 'readonly' => 'readonly' , 'class' => 'form-control')); ?>
<?php else: ?>
    <?php echo $this->Form->input('registro', array('type' => 'text', 'label' => 'Registro (DRE)', 'size' => 9, 'maxlenght' => 9, 'class' => 'form-control')); ?>
<?php endif ?>
<?php echo $this->Form->input('muralestagio_id', array('type' => 'hidden', 'value' => $muralestagio_id)); ?> 
<?php echo $this->Form->input('data', array('type' => 'hidden', 'value' => date('Y-m-d'))); ?> 
<?php echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo_atual)); ?> 
<br>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
        <?php echo $this->Form->end(); ?> 
    </div>
</div>