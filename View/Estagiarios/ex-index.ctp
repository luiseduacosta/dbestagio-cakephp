<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {
$("#EstagiarioPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        window.location="/estagiarios/index/periodo:"+periodo;
	})

$("#EstagiarioIdArea").change(function() {
	var id_area = $(this).val();
    	window.location="/estagiarios/index/id_area:"+id_area;
    	/* alert(id_area); */
	})

$("#EstagiarioDocenteId").change(function() {
	var docente_id = $(this).val();
    	/* alert(docente_id); */
    	window.location="/estagiarios/index/docente_id:"+docente_id;
	})

$("#EstagiarioIdInstituicao").change(function() {
	var instituicao_id = $(this).val();
    	/* alert(instituicao_id); */
    	window.location="/estagiarios/index/instituicao_id:"+instituicao_id;
	})

$("#EstagiarioIdSupervisor").change(function() {
	var supervisor_id = $(this).val();
    	/* alert(supervisor_id); */
    	window.location="/estagiarios/index/supervisor_id:"+supervisor_id;
	})

    });

', array("inline"=>false));

?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <p>
    <?php echo $this->Html->link('Alunos', '/alunos/index'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link("Inserir aluno", "/estagiarios/add_estagiario"); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link("Busca aluno", "/alunos/busca"); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link("Inserir estágio", '/estagiarios/add_estagiario'); ?>

    <?php echo " | "; ?>
    <?php echo $this->Html->link('Estagiários sem estágio', '/estagiarios/alunorfao'); ?>
    </p>
    <hr />
<?php endif; ?>

<?php if ($this->Session->read('categoria')): ?>
    <p>
    <?php echo $this->Html->link('Alunos', '/alunos/index'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link("Busca aluno", "/alunos/busca"); ?>
     </p>
    <hr />
<?php endif; ?>

<div id="estagiario_seleciona">

<table>
<tr>
	<td>
	<?php echo $this->Form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $this->Form->input('periodo', array('type'=>'select', 'options'=> $opcoes, 'default'=>$periodo, 'empty' => 'Todos')); ?>
	<?php echo $this->Form->end(); ?>
	</td>

	<td>
	<?php echo $this->Form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $this->Form->input('id_area', array('label'=>'Áreas', 'type'=>'select', 'options'=> $areas, 'default'=>$id_area)); ?>
	<?php echo $this->Form->end(); ?>
	</td>

	<td>
	<?php echo $this->Form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $this->Form->input('docente_id', array('label'=>'Professores', 'type'=>'select', 'options'=> $professores, 'selected'=>$docente_id, 'default'=>0)); ?>
	<?php echo $this->Form->end(); ?>
	</td>
</tr>

<tr>
	<td colspan = '3'>
	<?php echo $this->Form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $this->Form->input('supervisor_id', array('label'=>'Supervisores', 'type'=>'select', 'options'=> $supervisores, 'selected'=>$supervisor_id, 'default'=>0)); ?>
	<?php echo $this->Form->end(); ?>
	</td>
</tr>

<tr>
	<td colspan = '3'>
	<?php echo $this->Form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $this->Form->input('instituicaoestagio_id', array('label'=>'Instituições', 'type'=>'select', 'options'=> $instituicoes, 'selected'=>$instituicao_id, 'default'=>0)); ?>
	<?php echo $this->Form->end(); ?>
	</td>
</tr>
</table>

</div>

<div align='center'>

<?php ($periodo == 0 ? $periodo = "Todos" : $periodo = $periodo); ?>
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
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <th><?php echo $this->Paginator->sort('Estagiario.registro', 'Registro'); ?></th>
<?php endif; ?>
<th><?php echo $this->Paginator->sort('Aluno.nome', 'Nome'); ?></th>
<th><?php echo $this->Paginator->sort('Estagiario.periodo', 'Periodo'); ?></th>
<th><?php echo $this->Paginator->sort('Estagiario.nivel', 'Nível'); ?></th>
<th><?php echo $this->Paginator->sort('Estagiario.turno', 'Turno'); ?></th>
<th><?php echo $this->Paginator->sort('Estagiario.tc', 'TC'); ?></th>
<th><?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?></th>
<th><?php echo $this->Paginator->sort('Supervisor.nome', 'Supervisor'); ?></th>
<th><?php echo $this->Paginator->sort('Professor.nome', 'Professor'); ?></th>
<th><?php echo $this->Paginator->sort('Area.area', 'Área'); ?></th>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <th><?php echo $this->Paginator->sort('Estagiario.nota', 'Nota'); ?></th>
    <th><?php echo $this->Paginator->sort('Estagiario.ch', 'CH'); ?></th>
<?php endif; ?>
</tr>
<?php foreach ($estagiarios as $aluno):  ?>
<tr>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'],"/alunos/view/". $aluno['Aluno']['id']); ?></td>
<?php endif; ?>
<td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['periodo']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['nivel']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['turno']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['tc']; ?></td>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Instituicao']['instituicao'],"/Instituicoes/view/". $aluno['Estagiario']['instituicaoestagio_id']); ?></td>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Supervisor']['nome'],"/Supervisors/view/". $aluno['Estagiario']['supervisor_id']); ?></td>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Professor']['nome'],"/Professors/view/". $aluno['Estagiario']['docente_id']); ?></td>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Area']['area'], "/Areas/view/" . $aluno['Area']['id']); ?></td>
<?php else: ?>
    <td style='text-align:left'><?php echo $aluno['Instituicao']['instituicao']; ?></td>
    <td style='text-align:left'><?php echo $aluno['Supervisor']['nome']; ?></td>
    <td style='text-align:left'><?php echo $aluno['Professor']['nome']; ?></td>
    <td style='text-align:left'><?php echo $aluno['Area']['area']; ?></td>
<?php endif; ?>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <td style='text-align:center'><?php echo $aluno['Estagiario']['nota']; ?></td>
    <td style='text-align:center'><?php echo $aluno['Estagiario']['ch']; ?></td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
