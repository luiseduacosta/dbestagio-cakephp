<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#MuralCargaHoraria").mask("99");
    $("#MuralHorarioSelecao").mask("99:99");

});

', array('inline'=>false));

?>

<h1>Inserir solicitação de vagas para estágio</h1>

<?php echo $form->create('Mural'); ?>

<?php echo $form->input('periodo', array('type'=>'hidden', 'value'=>$periodo)); ?>

<?php echo $form->input('id_estagio', array('label'=>'Instituição', 'type'=>'select', 'options'=>$instituicoes)); ?>

<?php echo $form->input('convenio', array('label'=>'Convênio com a UFRJ', 'type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim'), 'selected'=>0)); ?>

<?php echo $form->input('vagas', array('label'=>'Vagas (digitar somente números inteiros)', 'default'=>0)); ?>

<?php echo $form->input('beneficios'); ?>

<?php echo $form->input('final_de_semana', array('label'=>'Estágio de final de semana', 'type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim', '2'=>'Parcialmente'), 'selected'=>0)); ?>

<?php echo $form->input('cargaHoraria'); ?>

<?php echo $form->input('requisitos', array('rows'=>4)); ?>

<?php echo $form->input('id_area', array('label'=>'Área de OTP', 'type'=>'select', 'options'=>$areas)); ?>

<?php echo $form->input('horario', array('label'=>'Horário da OTP', 'type'=>'select', 'options'=>array('D'=>'Diurno', 'N'=>'Noturno', 'A'=>'Ambos'))); ?>

<?php echo $form->input('id_professor', array('label'=>'Professor', 'type'=>'select', 'options'=>$professores)); ?>

<?php echo $form->input('dataSelecao', array('label'=>'Data da seleção', 'dateFormat'=>'DMY', 'minYear'=>'2000', 'empty'=>TRUE)); ?>

<?php echo $form->input('horarioSelecao'); ?>

<?php echo $form->input('localSelecao'); ?>

<?php echo $form->input('formaSelecao', array('label'=>'Forma de seleção', 'type'=>'select', 'options'=>array('0'=>'Entrevista', '1'=>'CR', '2'=>'Prova', '3'=>'Outras'))); ?>

<?php echo $form->input('dataInscricao', array('label'=>'Data final da inscrição', 'dateFormat'=>'DMY', 'minYear'=>'2000', 'empty'=>TRUE)); ?>

<?php echo $form->input('contato'); ?>

<?php echo $form->input('email', array('label'=>'Email para envio da lista de inscrições')); ?>

<?php echo $form->input('datafax', array('label'=>'Data de envio do email (preenchimento automático)', 'empty'=>TRUE)); ?>

<?php echo $form->input('outras', array('label'=>'Outras informações')); ?>

<?php echo $form->end('Confirmar'); ?>
