<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->scriptBlock('

$(document).ready(function(){
$("#InscricaoIdInstituicao").change(function() {
	var id_instituicao = $(this).val();
	 $("#InscricaoIdSupervisor").load("/mural/Instituicaos/seleciona_supervisor/"+id_instituicao, {id: $(this).val(), ajax: "true"});
         /* alert(id_instituicao); */
	})
 });
 
', array('inline'=>false));

?>

<?php echo $html->link('Solicita termo', '/Inscricaos/termosolicita'); ?>
<h1>Solicitação de Termo de Compromisso para cursar estágio no período
<?php echo $periodo; ?></h1>

<?php 

echo $form->create('Inscricao', array('action'=>'termocadastra/' . $id));

echo $form->input('id_aluno', array('type'=>'hidden', 'label'=>'Registro', 'value'=>$id));
echo "Registro (DRE): " . $id . "<br>";

echo $form->input('aluno_nome', array('type'=>'hidden', 'value'=>$aluno));
echo "Nome: " . $aluno . "<br>";

echo $form->input('nivel', array('type'=>'hidden', 'value'=>$nivel));
echo "Nível de estágio: " . $nivel . "<br>";

echo $form->input('periodo', array('type'=>'hidden', 'value'=>$periodo));
echo "Período: " . $periodo . "<br>";

echo $form->input('turno', array('type'=>'hidden', 'value'=>$turno));
if ($turno == 'D') {
	$turno = 'Diurno';
} elseif ($turno == 'N') {
	$turno = 'Noturno';
} elseif ($turno == 'I') {
	$turno = 'Indefinido';
} else {
        $turno = 'Sem dados';
}

echo "Turno: " . $turno . "<br>";

echo $form->input('id_professor', array('type'=>'hidden', 'label'=>'Professor', 'value'=>$professor_atual));

echo $form->input('id_instituicao', array('type'=>'select', 'label'=>'Instituição (É obrigatório selecionar a instituição)', 'options'=>$instituicoes, 'selected'=>$instituicao_atual));
echo $form->input('id_supervisor', array('type'=>'select', 'label'=>'Supervisor (Se não souber quem é o supervisor deixar em branco)', 'options'=>$supervisores, 'selected'=>$supervisor_atual));

echo $form->end('Confirmar');

?>
