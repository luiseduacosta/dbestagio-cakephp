<h5>Digite o número de DRE</h5>

<?php echo $this->Form->create('Muralinscricao'); ?>
<?php echo $this->Form->input('registro', ['class' => 'form-control']);  ?>
<?php echo $this->Form->input('instituicaoestagio_id', ['type'=>'hidden', 'value'=>$instituicao_id]); ?> 
<?php echo $this->Form->submit("Confirma", ['class' => 'btn btn-success']); ?>
<?php echo $this->Form->end(); ?>
