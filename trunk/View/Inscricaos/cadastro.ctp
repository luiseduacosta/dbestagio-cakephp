<h1>Digite o número de DRE</h1>

<?php

echo $this->Form->create('Inscricao', array('action'=>'cadastro'));
echo $this->Form->input('registro');
echo $this->Form->input('id_instituicao', array('type'=>'hidden', 'value'=>$id_instituicao));
echo $this->Form->end('Confirma');

?>
