<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function(){
$("#EstagiarioIdInstituicao").change(function() {
	var id_instituicao = $(this).val();
	 $("#EstagiarioIdSupervisor").load("/mycake/Instituicaos/seleciona_supervisor/"+id_instituicao, {id: $(this).val(), ajax: "true"});
         /* alert(id_instituicao); */
	})
 });

', array('inline'=>false));

?>

<?php

echo $this->Html->script("jquery.maskedinput", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    $("#EstagiarioNota").mask("99.99");
    $("#EstagiarioCh").mask("999");

});

', array('inline'=>false));

?>

<?php

?>

<h1>Inserir estágio</h1>

<?php if (!isset($proximo_nivel)) $proximo_nivel = 1; ?>

<?php if (isset($estagiarios)): ?>
    <table border='1'>
    <caption>Estágios cursados</caption>
    <tr>
    <th>Excluir</th>
    <th>Editar</th>
    <th>Período</th>
    <th>Nível</th>
    <th>Turno</th>
    <th>TC</th>
    <th>Solicitação do TC</th>
    <th>Instituição</th>
    <th>Supervisor</th>
    <th>Professor</th>
    <th>Área</th>
    <th>Nota</th>
    <th>CH</th>
    </tr>

    <?php foreach ($estagiarios as $c_estagio): ?>
    <tr>
    <td>
    <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
    </td>
    <td>
    <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_estagio['Estagiario']['id']); ?>
    </td>
    <td><?php echo $c_estagio['Estagiario']['periodo'] ?></td>
    <td><?php echo $c_estagio['Estagiario']['nivel']; ?></td>
    <td><?php echo $c_estagio['Estagiario']['turno']; ?></td>
    <td><?php echo $c_estagio['Estagiario']['tc']; ?></td>
    <td><?php echo $c_estagio['Estagiario']['tc_solicitacao']; ?></td>
    <td><?php echo $c_estagio['Instituicao']['instituicao'] ?></td>
    <td><?php echo $c_estagio['Supervisor']['nome'] ?></td>
    <td><?php echo $c_estagio['Professor']['nome'] ?></td>
    <td><?php echo $c_estagio['Area']['area'] ?></td>
    <td><?php echo $c_estagio['Estagiario']['nota'] ?></td>
    <td><?php echo $c_estagio['Estagiario']['ch'] ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php
echo $this->Form->create('Estagiario');
?>

<?php
$hoje = date('d/m/Y');
?>

<fieldset><legend>Estudante</legend>

<h1>
    <?php 
    if ($estagiarios) {
        echo $estagiarios[0]['Aluno']['nome']; 
    } else {
        echo $aluno['Aluno']['nome']; 
    }
    ?>
</h1>

</fieldset>

<fieldset><legend>Estágio</legend>
<?php
    if ($estagiarios) {
    echo $this->Form->input('Estagiario.id_aluno', array('type'=>'hidden', 'value'=>$estagiarios[0]['Estagiario']['id_aluno']));
    echo $this->Form->input('Estagiario.registro', array('type'=>'hidden', 'value'=>$estagiarios[0]['Estagiario']['registro']));
   } else {
    echo $this->Form->input('Estagiario.id_aluno', array('type'=>'hidden', 'value'=>$aluno['Aluno']['id']));
    echo $this->Form->input('Estagiario.registro', array('type'=>'hidden', 'value'=>$aluno['Aluno']['registro']));
   }   
?>

<?php
echo 'Termo de compromisso: '. $this->Form->input('Estagiario.tc', array('type'=>'radio', 'label'=>'Termo de compromisso', 'legend'=>FALSE, 'options'=>array('0'=>'Não','1'=>'Sim'),'default'=>'0'));
echo $this->Form->input('Estagiario.periodo', array('type'=>'select', 'label'=>'Período', 'options'=>$periodos, 'selected'=>$periodo_atual));
echo 'Nível: '. $this->Form->input('Estagiario.nivel', array('type'=>'radio', 'legend'=>FALSE, 'label'=>'Nível', 'options'=>array('1'=>'I','2'=>'II','3'=>'III','4'=>'IV'), 'default'=>$proximo_nivel));
echo 'Turno: '. $this->Form->input('Estagiario.turno', array('type'=>'radio', 'legend'=>FALSE, 'label'=>'Turno', 'options'=>array('D'=>'Diurno','N'=>'Noturno'), 'default'=>'D'));
echo $this->Form->input('Estagiario.tc_solicitacao', array('label'=>'Data de solicitação do TC (inserida automáticamente quando o estudante solicita o TC)', 'dateFormat'=>'DMY', 'selected'=>array('day'=>date('d'), 'month'=>date('m'), 'year'=>date('Y'))));
echo $this->Form->input('Estagiario.id_instituicao', array('label'=>'Instituição','options'=>$instituicoes,'default'=>0));
echo $this->Form->input('Estagiario.id_supervisor', array('label'=>'Supervisor','options'=>$supervisores, 'default'=>0, 'empty'=>'Seleciona'));
echo $this->Form->input('Estagiario.id_professor', array('label'=>'Professor','options'=>$professores, 'default'=>0, 'empty'=>'Seleciona'));
echo $this->Form->input('Estagiario.id_area', array('label'=>'Área temática','options'=>$areas, 'default'=>0, 'empty'=>'Seleciona'));
echo $this->Form->input('Estagiario.nota', array('label'=>'Nota'));
echo $this->Form->input('Estagiario.ch', array('label'=>'Carga horária'));
?>
</fieldset>

<?php
echo $this->Form->end('Confirma');
?>
