<h5>Inscrição para seleção de estágio</h5>

<?php

echo $this->Form->create('Inscricao');
echo $this->Form->input('aluno_id', array('type'=>'hidden'));
echo $this->Form->input('instituicao_id', array('type'=>'hidden'));
echo $this->Form->input('Mural.instituicao', array('type'=>'hidden'));
echo $this->Form->input('data', array('dateFormat'=>'DMY', 'type'=>'hidden'));
echo $this->Form->input('periodo', array('type'=>'hidden'));
echo $this->Form->submit('Confirma');
echo $this->Form->end();

?>
