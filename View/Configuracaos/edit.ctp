<?php 

echo $this->Form->create('Configuracao');
echo $this->Form->input('mural_periodo_atual');
echo $this->Form->input('curso_turma_atual');
echo $this->Form->input('curso_abertura_inscricoes', array('label'=>'Data de abertura das inscrições para o curso de supervisores', 'dateFormat'=>'DMY'));
echo $this->Form->input('curso_encerramento_inscricoes', array('label'=>'Data de encerramento das inscrições para o curso de supervisores', 'dateFormat'=>'DMY'));
echo $this->Form->input('termo_compromisso_periodo');
echo $this->Form->input('termo_compromisso_inicio', array('label'=>'Data de inicio do termo de compromisso', 'dateFormat'=>'DMY'));
echo $this->Form->input('termo_compromisso_final', array('label'=>'Data de finalização do termo de compromisso', 'dateFormat'=>'DMY'));
echo $this->Form->end('Confirma')

?>
