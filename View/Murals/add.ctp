<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->script("jquery.maskedinput", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    $("#MuralCargaHoraria").mask("99");
    $("#MuralHorarioSelecao").mask("99:99");

});

', array('inline'=>false));

?>

<h1>Inserir solicitação de vagas para estágio</h1>

<?php echo $this->Form->create('Mural'); ?>

<?php echo $this->Form->input('periodo', array('type'=>'hidden', 'value'=>$periodo)); ?>

<?php echo $this->Form->input('id_estagio', array('label'=>'Instituição (se a instituição não está cadastrada, tem que cadastrar no menu Instituições)', 'type'=>'select', 'options'=>$instituicoes)); ?>

<?php echo $this->Form->input('convenio', array('label'=>'Convênio com a UFRJ', 'type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim'))); ?>

<?php echo $this->Form->input('vagas', array('label'=>'Vagas (digitar somente números inteiros)', 'default'=>0)); ?>

<?php echo $this->Form->input('beneficios'); ?>

<?php echo $this->Form->input('final_de_semana', array('label'=>'Estágio de final de semana', 'type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim', '2'=>'Parcialmente'), 'selected'=>0)); ?>

<?php echo $this->Form->input('cargaHoraria'); ?>

<?php echo $this->Form->input('requisitos', array('rows'=>4)); ?>

<?php echo $this->Form->input('id_area', array('label'=>'Área de OTP', 'type'=>'select', 'options'=>$areas)); ?>

<?php echo $this->Form->input('horario', array('label'=>'Horário da OTP', 'type'=>'select', 'options'=>array('D'=>'Diurno', 'N'=>'Noturno', 'A'=>'Ambos'))); ?>

<?php echo $this->Form->input('docente_id', array('label'=>'Professor', 'type'=>'select', 'options'=>$professores)); ?>

<?php echo $this->Form->input('dataSelecao', array('label'=>'Data da seleção', 'dateFormat'=>'DMY', 'minYear'=>'2000', 'empty'=>TRUE)); ?>

<?php echo $this->Form->input('horarioSelecao'); ?>

<?php echo $this->Form->input('localSelecao'); ?>

<?php echo $this->Form->input('formaSelecao', array('label'=>'Forma de seleção', 'type'=>'select', 'options'=>array('0'=>'Entrevista', '1'=>'CR', '2'=>'Prova', '3'=>'Outras'))); ?>

<?php echo $this->Form->input('dataInscricao', array('label'=>'Data final da inscrição', 'dateFormat'=>'DMY', 'minYear'=>'2000', 'empty'=>TRUE)); ?>

<?php echo $this->Form->input('contato'); ?>

<?php echo $this->Form->input('email', array('label'=>'Email para envio da lista de inscrições')); ?>

<?php echo $this->Form->input('datafax', array('label'=>'Data de envio do email (preenchimento automático)', 'empty'=>TRUE)); ?>

<?php echo $this->Form->input('localInscricao', array('label'=>'Inscrição na Coordenação de Estágio ou diretamente na instituição', 'type'=>'select', 'options' => array('0'=>'Mural da Coordenação de Estágio/ESS', '1'=>'Diretamente na Instituição'))); ?>

<?php echo $this->Form->input('outras', array('label'=>'Outras informações')); ?>

<?php echo $this->Form->end('Confirmar'); ?>
