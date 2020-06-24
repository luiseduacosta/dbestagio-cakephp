<?php

?>

<script>

$(document).ready(function(){

    /* $("#InscricaoIdAluno").mask("999999999"); */

});
</script>

<h5>Digite o número de DRE</h5>

<?php echo $this->Form->create('Inscricao', ['url' => '/Inscricoes/inscricao/registro:' . $this->Session->read('numero') . '/mural_estagio_id:' . $mural_estagio_id]); ?>
<?php $numero = $this->Session->read('numero'); ?>
<?php echo $this->Form->input('aluno_id', array('type' => 'text', 'label'=>'Registro (DRE)', 'size'=> 9, 'maxlenght'=> 9, 'value' => $this->Session->read('numero'), 'class' => 'form-control')); ?>
<?php echo $this->Form->input('mural_estagio_id', array('type'=>'hidden', 'value'=>$mural_estagio_id)); ?> 
<br>
<?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-primary']); ?>
<?php echo $this->Form->end(); ?> 

