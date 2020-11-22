<h5>Cadastro de estudante para seleção de estágio</h5>

<?php echo $this->Form->create('Muralinscricao'); ?>
<?php if ($this->Session->read('id_categoria') == 2): ?>
    <?php echo $this->Form->input('registro', array('type' => 'text', 'label' => 'Registro (DRE)', 'size' => 9, 'maxlenght' => 9, 'value' => $this->Session->read('numero'), 'readonly' => 'readonly' , 'class' => 'form-control')); ?>
<?php else: ?>
    <?php echo $this->Form->input('registro', array('type' => 'text', 'label' => 'Registro (DRE)', 'size' => 9, 'maxlenght' => 9, 'class' => 'form-control')); ?>
<?php endif ?>
<?php echo $this->Form->input('muralestagio_id', array('value' => $muralestagio_id)); ?> 
<?php echo $this->Form->input('data', array('value' => date('Y-m-d'))); ?> 
<?php echo $this->Form->input('periodo', array('value' => $periodo_atual)); ?> 
<br>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
        <?php echo $this->Form->end(); ?> 
    </div>
</div>