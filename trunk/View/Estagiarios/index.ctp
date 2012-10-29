<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {
$("#EstagiarioPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        window.location="/mycake/estagiarios/index/periodo:"+periodo;
	})

$("#EstagiarioIdArea").change(function() {
	var id_area = $(this).val();
    	window.location="/mycake/estagiarios/index/id_area:"+id_area;
    	/* alert(id_area); */
	})

$("#EstagiarioIdProfessor").change(function() {
	var id_professor = $(this).val();
    	/* alert(id_professor); */
    	window.location="/mycake/estagiarios/index/id_professor:"+id_professor;
	})

$("#EstagiarioIdInstituicao").change(function() {
	var id_instituicao = $(this).val();
    	/* alert(id_instituicao); */
    	window.location="/mycake/estagiarios/index/id_instituicao:"+id_instituicao;
	})

$("#EstagiarioIdSupervisor").change(function() {
	var id_supervisor = $(this).val();
    	/* alert(id_supervisor); */
    	window.location="/mycake/estagiarios/index/id_supervisor:"+id_supervisor;
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
    <?php echo $this->Html->link('Alunos sem estágio', '/estagiarios/alunorfao'); ?>
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
	<?php echo $this->Form->input('id_professor', array('label'=>'Professores', 'type'=>'select', 'options'=> $professores, 'selected'=>$id_professor, 'default'=>0)); ?>
	<?php echo $this->Form->end(); ?>
	</td>
</tr>

<tr>
	<td colspan = '3'>
	<?php echo $this->Form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $this->Form->input('id_supervisor', array('label'=>'Supervisores', 'type'=>'select', 'options'=> $supervisores, 'selected'=>$id_supervisor, 'default'=>0)); ?>
	<?php echo $this->Form->end(); ?>
	</td>
</tr>

<tr>
	<td colspan = '3'>
	<?php echo $this->Form->create('Estagiario', array('action'=>'index')); ?>
	<?php echo $this->Form->input('id_instituicao', array('label'=>'Instituições', 'type'=>'select', 'options'=> $instituicoes, 'selected'=>$id_instituicao, 'default'=>0)); ?>
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
<? endif; ?>
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
<? endif; ?>
</tr>
<?php foreach ($estagiarios as $aluno):  ?>
<tr>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'],"/alunos/view/". $aluno['Aluno']['id']); ?></td>
<? endif; ?>    
<td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['periodo']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['nivel']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['turno']; ?></td>
<td style='text-align:center'><?php echo $aluno['Estagiario']['tc']; ?></td>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Instituicao']['instituicao'],"/instituicaos/view/". $aluno['Estagiario']['id_instituicao']); ?></td>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Supervisor']['nome'],"/supervisors/view/". $aluno['Estagiario']['id_supervisor']); ?></td>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Professor']['nome'],"/professors/view/". $aluno['Estagiario']['id_professor']); ?></td>
    <td style='text-align:left'><?php echo $this->Html->link($aluno['Area']['area'], "/Areas/view/" . $aluno['Area']['id']); ?></td>
<?php else: ?>
    <td style='text-align:left'><?php echo $aluno['Instituicao']['instituicao']; ?></td>
    <td style='text-align:left'><?php echo $aluno['Supervisor']['nome']; ?></td>
    <td style='text-align:left'><?php echo $aluno['Professor']['nome']; ?></td>
    <td style='text-align:left'><?php echo $aluno['Area']['area']; ?></td>
<? endif; ?>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <td style='text-align:center'><?php echo $aluno['Estagiario']['nota']; ?></td>
    <td style='text-align:center'><?php echo $aluno['Estagiario']['ch']; ?></td>
<? endif; ?>
</tr>
<?php endforeach; ?>
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
