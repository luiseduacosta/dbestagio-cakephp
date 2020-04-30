<h1>Digite o número de DRE</h1>

<?php

echo $this->Form->create('Inscricao', array('action'=>'cadastro'));
echo $this->Form->input('registro');
echo $this->Form->input('instituicao_id', array('type'=>'hidden', 'value'=>$instituicao_id));
echo $this->Form->end('Confirma');

?>
