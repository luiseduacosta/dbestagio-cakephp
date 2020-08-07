<?php ?>

<h5>Digite o número de DRE</h5>

<?php echo $this->Form->create('Inscricao', ['url' => '/Inscricoes/inscricao/registro:' . $this->Session->read('numero') . '/muralestagio_id:' . $muralestagio_id]); ?>
<?php $numero = $this->Session->read('numero'); ?>
<?php echo $this->Form->input('registro', array('type' => 'text', 'label' => 'Registro (DRE)', 'size' => 9, 'maxlenght' => 9, 'value' => $this->Session->read('numero'), 'class' => 'form-control')); ?>
<?php echo $this->Form->input('muralestagio_id', array('type' => 'hidden', 'value' => $muralestagio_id)); ?> 
<br>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
        <?php echo $this->Form->end(); ?> 
    </div>
</div>