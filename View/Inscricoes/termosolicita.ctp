<h1>Digite o seu número de DRE para solicitar termo de compromisso</h1>

<?php

echo $this->Form->create('Inscricao');
echo $this->Form->input('aluno_id', array('type' => 'text', 'label'=>'Registro (DRE)', 'size'=>'9', 'maxlength'=>'9', 'default'=>$this->Session->read('numero')));
echo $this->Form->end('Confirma');

?>
