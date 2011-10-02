<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->scriptBlock('

$(document).ready(function() {
$("#EstagiarioPeriodo").change(function() {
		var periodo = $(this).val();
        /* alert(periodo); */
        window.location="/mural/Estagiarios/index/periodo:"+periodo;
		})

$("#EstagiarioIdArea").change(function() {
		var id_area = $(this).val();
    	window.location="/mural/Estagiarios/index/id_area:"+id_area;
    	/* alert(id_area); */
		})

$("#EstagiarioIdProfessor").change(function() {
		var id_professor = $(this).val();
    	/* alert(id_professor); */
    	window.location="/mural/Estagiarios/index/id_professor:"+id_professor;
		})

$("#EstagiarioIdInstituicao").change(function() {
		var id_instituicao = $(this).val();
    	/* alert(id_instituicao); */
    	window.location="/mural/Estagiarios/index/id_instituicao:"+id_instituicao;
		})

$("#EstagiarioIdSupervisor").change(function() {
		var id_supervisor = $(this).val();
    	/* alert(id_supervisor); */
    	window.location="/mural/Estagiarios/index/id_supervisor:"+id_supervisor;
		})

    });

', array("inline"=>false));

?>

<?php echo $this->element('submenu'); ?>

<p>
<?php echo $html->link('Listar alunos', '/alunos/index'); ?>
<?php echo " | "; ?>
<?php echo $html->link("Inserir aluno", "/estagiarios/add_estagiario"); ?>
<?php echo " | "; ?>
<?php echo $html->link("Busca aluno", "/alunos/busca"); ?>
<?php echo " | "; ?>
<?php echo $html->link("Inserir estágio", '/estagiarios/add_estagiario'); ?>

<?php echo " | "; ?>
<?php echo $html->link('Alunos sem estágio', '/estagiarios/alunorfao'); ?>
</p>
<hr />

<div id="estagiario_seleciona">

<table>
<tr>
	<td>
	<?php echo $form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $form->input('periodo', array('type'=>'select', 'options'=> $opcoes, 'default'=>$periodo)); ?>
	<?php echo $form->end(); ?>
	</td>

	<td>
	<?php echo $form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $form->input('id_area', array('label'=>'Áreas', 'type'=>'select', 'options'=> $areas, 'default'=>$id_area)); ?>
	<?php echo $form->end(); ?>
	</td>

	<td>
	<?php echo $form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $form->input('id_professor', array('label'=>'Professores', 'type'=>'select', 'options'=> $professores, 'selected'=>$id_professor, 'default'=>0)); ?>
	<?php echo $form->end(); ?>
	</td>
</tr>

<tr>
	<td colspan = '3'>
	<?php echo $form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $form->input('id_supervisor', array('label'=>'Supervisores', 'type'=>'select', 'options'=> $supervisores, 'selected'=>$id_supervisor, 'default'=>0)); ?>
	<?php echo $form->end(); ?>
	</td>
</tr>

<tr>
	<td colspan = '3'>
	<?php echo $form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $form->input('id_instituicao', array('label'=>'Instituições', 'type'=>'select', 'options'=> $instituicoes, 'selected'=>$id_instituicao, 'default'=>0)); ?>
	<?php echo $form->end(); ?>
	</td>
</tr>
</table>

</div>

<div align='center'>
<h1>Estagiarios período: <?php echo $periodo; ?></h1>

<?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->prev('< Anterior ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->next(' Posterior > ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->last(' Último >> ', null, null, array('class'=>'disabled')); ?>

<br/>

<?php echo $this->Paginator->numbers(); ?>
</div>

<table border='1'>
<tr>
<th><?php echo $this->Paginator->sort('Registro','Estagiario.registro'); ?></th>
<th><?php echo $this->Paginator->sort('Nome','Aluno.nome'); ?></th>
<th><?php echo $this->Paginator->sort('Periodo','Estagiario.periodo'); ?></th>
<th><?php echo $this->Paginator->sort('Nível','Estagiario.nivel'); ?></th>
<th><?php echo $this->Paginator->sort('Turno','Estagiario.turno'); ?></th>
<th><?php echo $this->Paginator->sort('TC','Estagiario.tc'); ?></th>
<th><?php echo $this->Paginator->sort('Instituição','Instituicao.instituicao'); ?></th>
<th><?php echo $this->Paginator->sort('Supervisor','Supervisor.nome'); ?></th>
<th><?php echo $this->Paginator->sort('Professor','Professor.nome'); ?></th>
<th><?php echo $this->Paginator->sort('Área','Area.area'); ?></th>
<th><?php echo $this->Paginator->sort('Nota','Estagiario.nota'); ?></th>
<th><?php echo $this->Paginator->sort('CH','Estagiario.ch'); ?></th>
</tr>
<?php foreach ($estagiarios as $aluno):  ?>
<tr>
<td style='text-align:center'><?php echo $html->link($aluno['Estagiario']['registro'],"/alunos/view/". $aluno['Aluno']['id']); ?></td>
<td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['periodo']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['nivel']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['turno']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['tc']; ?></td>
<td style='text-align:left'><?php echo $html->link($aluno['Instituicao']['instituicao'],"/instituicaos/view/". $aluno['Estagiario']['id_instituicao']); ?></td>
<td style='text-align:left'><?php echo $html->link($aluno['Supervisor']['nome'],"/supervisors/view/". $aluno['Estagiario']['id_supervisor']); ?></td>
<td style='text-align:left'><?php echo $html->link($aluno['Professor']['nome'],"/professors/view/". $aluno['Estagiario']['id_professor']); ?></td>
<td style='text-align:left'><?php echo $html->link($aluno['Area']['area'], "/Areas/view/" . $aluno['Area']['id']); ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['nota']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['ch']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
