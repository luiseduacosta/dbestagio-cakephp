<h1>Inscrição para seleção de estágio</h1>

<?php

echo $form->create('Inscricao');
echo $form->input('id_aluno', array('type'=>'hidden'));
echo $form->input('id_instituicao', array('type'=>'hidden'));
echo $form->input('Mural.instituicao', array('type'=>'hidden'));
echo $form->input('data', array('dateFormat'=>'DMY', 'type'=>'hidden'));
echo $form->input('periodo', array('type'=>'hidden'));
echo $form->end('Confirma');

?>
