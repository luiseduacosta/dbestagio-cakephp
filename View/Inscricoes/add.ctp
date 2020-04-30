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

echo $this->Form->create('Inscricao');
$numero = $this->Session->read('numero');
echo $this->Form->input('aluno_id', array('type' => 'text', 'label'=>'Registro (DRE)', 'size'=> 9, 'maxlenght'=> 9, 'value' => $this->Session->read('numero')));
echo $this->Form->input('mural_estagio_id', array('type'=>'hidden', 'value'=>$instituicao_id));
echo $this->Form->submit('Confirma');
echo $this->Form->end();

?>
