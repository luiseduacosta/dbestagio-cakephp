<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->scriptBlock('

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

echo $form->create('Estagiario');
echo $form->input('Estagiario.periodo', array('label'=>'Período','options'=>$periodos));
echo $form->input('Estagiario.nivel', array('label'=>'Nível','options'=>array('1'=>'I', '2'=>'II', '3'=>'III', '4'=>'IV')));
echo $form->input('Estagiario.turno', array('label'=>'Turno', 'options'=>array('D'=>'Diurno', 'N'=>'Noturno', 'I'=>'Indefinido')));
echo $form->input('Estagiario.tc', array('label'=>'TC (Aluno entrogou o TC assinado na Coordenação de Estágio?', 'options'=>array('0'=>'Não', '1'=>'Sim')));
echo $form->input('Estagiario.tc_solicitacao', array('type'=>'hidden', 'label'=>'Data de solicitação do TC', 'dateFormat'=>'DMY' ,'empty'=>TRUE));
echo $form->input('Estagiario.id_instituicao', array('label'=>'Instituição','options'=>$instituicoes));
echo $form->input('Estagiario.id_supervisor', array('label'=>'Supervisor','options'=>$supervisores));
echo $form->input('Estagiario.id_professor', array('label'=>'Professor','options'=>$professores));
echo $form->input('Estagiario.id_area', array('label'=>'Área temática','options'=>$areas));
echo $form->input('Estagiario.id_aluno', array('type'=>'hidden'));
echo $form->input('Estagiario.nota', array('label'=>'Nota: separar casas decimais com ponto'));
echo $form->input('Estagiario.ch', array('label'=>'Carga horária (Digitar números inteiros)'));
echo $form->input('id', array('type'=>'hidden'));
echo $form->end('Atualizar');

?>
