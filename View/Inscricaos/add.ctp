<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->script("jquery.maskedinput", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    /* $("#InscricaoIdAluno").mask("999999999"); */

});

', array('inline'=>false));

?>


<h1>Digite o número de DRE</h1>

<?php

echo $this->Form->create('Inscricao', array('action'=>'add/' . $id_instituicao));
$numero = $this->Session->read('numero');
if ($numero) {
	echo $this->Form->input('id_aluno', array('label'=>'Registro (DRE)', 'size'=>9, 'maxlenght'=>9, 'default'=>$this->Session->read('numero')));
} else {
	echo $this->Form->input('id_aluno', array('label'=>'Registro (DRE)', 'size'=>9, 'maxlenght'=>9, 'dafault'=>NULL));
}
echo $this->Form->input('id_instituicao', array('type'=>'hidden', 'value'=>$id_instituicao));
echo $this->Form->end('Confirma');

?>
