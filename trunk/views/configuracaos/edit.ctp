<?php 

echo $form->create('Configuracao');
echo $form->input('mural_periodo_atual');
echo $form->input('curso_turma_atual');
echo $form->input('curso_encerramento_inscricoes', array('label'=>'Data de encerramento das inscrições para o curso de supervisores', 'dateFormat'=>'DMY'));
echo $form->input('termo_compromisso_periodo');
echo $form->input('termo_compromisso_inicio', array('label'=>'Data de inicio do termo de compromisso', 'dateFormat'=>'DMY'));
echo $form->input('termo_compromisso_final', array('label'=>'Data de finalização do termo de compromisso', 'dateFormat'=>'DMY'));
echo $form->end('Confirma')

?>