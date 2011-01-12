<h1>Digite o número de DRE</h1>

<?php

echo $form->create('Inscricao', array('action'=>'cadastro'));
echo $form->input('registro');
echo $form->input('id_instituicao', array('type'=>'hidden', 'value'=>$id_instituicao));
echo $form->end('Confirma');

?>
