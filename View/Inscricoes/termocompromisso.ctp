<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function(){
$("#InscricaoIdInstituicao").change(function() {
	var instituicao_id = $(this).val();
	 $("#InscricaoIdSupervisor").load("/mural/Instituicoes/seleciona_supervisor/"+instituicao_id, {id: $(this).val(), ajax: "true"});
         /* alert(instituicao_id); */
	})
 });

', array('inline'=>false));

?>

<?php echo $this->Html->link('Solicita termo', '/Inscricoes/termosolicita'); ?>
<h1>Solicitação de Termo de Compromisso para cursar estágio no período
<?php echo $periodo; ?></h1>

<?php

echo $this->Form->create('Inscricao', array('url'=>'termocadastra/' . $id));

echo $this->Form->input('aluno_id', array('type'=>'hidden', 'label'=>'Registro', 'value'=>$id));
echo "Registro (DRE): " . $id . "<br>";

echo $this->Form->input('aluno_nome', array('type'=>'hidden', 'value'=>$aluno));
echo "Nome: " . $aluno . "<br>";

echo $this->Form->input('nivel', array('type'=>'hidden', 'value'=>$nivel));
echo "Nível de estágio: " . $nivel . "<br>";

echo $this->Form->input('periodo', array('type'=>'hidden', 'value'=>$periodo));
echo "Período: " . $periodo . "<br>";

echo $this->Form->input('turno', array('type'=>'hidden', 'value'=>$turno));
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

echo $this->Form->input('docente_id', array('type'=>'hidden', 'label'=>'Professor', 'value'=>$professor_atual));

echo $this->Form->input('instituicao_id', array('type'=>'select', 'label'=>'Instituição (É obrigatório selecionar a instituição)', 'options'=>$instituicoes, 'selected'=>$instituicao_atual));
echo $this->Form->input('supervisor_id', array('type'=>'select', 'label'=>'Supervisor (Se não souber quem é o supervisor deixar em branco)', 'options'=>$supervisores, 'selected'=>$supervisor_atual));

echo $this->Form->end('Confirmar');

?>
