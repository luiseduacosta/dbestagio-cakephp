<?php // pr($periodos); ?>

<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function(){
$("#EstagiarioIdInstituicao").change(function() {
	var id_instituicao = $(this).val();
	 $("#EstagiarioIdSupervisor").load("/mural/Instituicaos/seleciona_supervisor/"+id_instituicao, {id: $(this).val(), ajax: "true"});
         /* alert(id_instituicao); */
	})
 });

', array('inline'=>false));

?>

<h2><?php echo $aluno; ?></h2>

<?php

echo $this->Form->create('Estagiario');
echo $this->Form->input('Estagiario.periodo', array('label'=>'Período','options'=>$periodos));
echo $this->Form->input('Estagiario.nivel', array('label'=>'Nível','options'=>array('1'=>'I', '2'=>'II', '3'=>'III', '4'=>'IV', '9' => 'Não obrigatório')));
echo $this->Form->input('Estagiario.turno', array('label'=>'Turno', 'options'=>array('D'=>'Diurno', 'N'=>'Noturno', 'I'=>'Indefinido')));
echo $this->Form->input('Estagiario.tc', array('label'=>'TC (Aluno entrogou o TC assinado na Coordenação de Estágio?', 'options'=>array('0'=>'Não', '1'=>'Sim')));
echo $this->Form->input('Estagiario.tc_solicitacao', array('type'=>'hidden', 'label'=>'Data de solicitação do TC', 'dateFormat'=>'DMY' ,'empty'=>TRUE));
echo $this->Form->input('Estagiario.id_instituicao', array('label'=>'Instituição','options'=>$instituicoes));
echo $this->Form->input('Estagiario.id_supervisor', array('label'=>'Supervisor','options'=>$supervisores));
echo $this->Form->input('Estagiario.id_professor', array('label'=>'Professor','options'=>$professores));
echo $this->Form->input('Estagiario.id_area', array('label'=>'Área temática','options'=>$areas));
echo $this->Form->input('Estagiario.id_aluno', array('type'=>'hidden'));
echo $this->Form->input('Estagiario.nota', array('label'=>'Nota: separar casas decimais com ponto'));
echo $this->Form->input('Estagiario.ch', array('label'=>'Carga horária (Digitar números inteiros)'));
echo $this->Form->input('Estagiario.observacoes', array('label'=>'Observações'));
echo $this->Form->input('id', array('type'=>'hidden'));
echo $this->Form->end('Atualizar');

?>
