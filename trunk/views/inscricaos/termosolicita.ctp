<h1>Digite o seu número de DRE para solicitar termo de compromisso</h1>

<?php

echo $form->create('Inscricao');
echo $form->input('id_aluno', array('label'=>'Registro (DRE)', 'size'=>'9', 'maxlength'=>'9', 'default'=>$this->Session->read('numero')));
echo $form->end('Confirma');

?>
