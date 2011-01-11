<h1>Digite o número de DRE para solicitar termo de compromisso</h1>

<?php

echo $form->create('Inscricao');
echo $form->input('id_aluno', array('label'=>'Registro (DRE)', 'size'=>'9', 'maxlength'=>'9'));
echo $form->end('Confirma');

?>
