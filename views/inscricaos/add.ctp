<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#InscricaoIdAluno").mask("999999999");

});

', array('inline'=>false));

?>


<h1>Digite o número de DRE</h1>

<?php

echo $form->create('Inscricao', array('action'=>'add/' . $id_instituicao));
echo $form->input('id_aluno', array('label'=>'Registro (DRE)', 'size'=>9, 'maxlenght'=>9, 'default'=>$this->Session->read('numero')));
echo $form->input('id_instituicao', array('type'=>'hidden', 'value'=>$id_instituicao));
echo $form->end('Confirma');

?>
