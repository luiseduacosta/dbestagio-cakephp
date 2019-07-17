<?php

// pr($periodoatual); 
// pr($nivel); 
// pr($periodos_todos);
// pr($id_supervisor);
// pr($supervisores);

?>

<?php
echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;

var base_url = window.location.pathname.split("/");

$("#EstagiarioPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/estagiarios/index/periodo:"+periodo;
        } else {
            window.location="/estagiarios/index/periodo:"+periodo;
        }
})

$("#EstagiarioIdArea").change(function() {
	var id_area = $(this).val();
        /* alert(id_area); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/estagiarios/index/id_area:"+id_area;
        } else {
            window.location="/estagiarios/index/id_area:"+id_area;
        }
})

$("#EstagiarioIdProfessor").change(function() {
	var id_professor = $(this).val();
    	/* alert(id_professor); */
        if (url === "localhost") {        
            window.location="/" + base_url[1] + "/estagiarios/index/id_professor:"+id_professor;
        } else {
            window.location="/estagiarios/index/index/id_professor:"+id_professor;
        }
})

$("#EstagiarioIdInstituicao").change(function() {
	var id_instituicao = $(this).val();
    	/* alert(id_instituicao); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/estagiarios/index/id_instituicao:"+id_instituicao;
        } else {
            window.location="/estagiarios/index/id_instituicao:"+id_instituicao;
        }        
})

$("#EstagiarioIdSupervisor").change(function() {
	var id_supervisor = $(this).val();
    	/* alert(id_supervisor); */
        if (url === "localhost") {        
            window.location="/" + base_url[1] + "/estagiarios/index/id_supervisor:"+id_supervisor;
        } else {
            window.location="/estagiarios/index/id_supervisor:"+id_supervisor;
        }
})
  
$("#EstagiarioNivel").change(function() {
	var nivel = $(this).val();
    	/* alert(nivel); */
        if (url === "localhost") {        
    	window.location="/" + base_url[1] + "/estagiarios/index/nivel:"+nivel;
        } else {
            window.location="/estagiarios/index/nivel:"+nivel;
        }
})

$("#EstagiarioTurno").change(function() {
	var turno = $(this).val();
    	/* alert(turno); */
        if (url === "localhost") {        
    	window.location="/" + base_url[1] + "/estagiarios/index/turno:"+turno;
        } else {
            window.location="/estagiarios/index/turno:"+turno;
        }
})

});

', array("inline" => false));
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

<div id="estagiario_seleciona" style="align-content: center;">
    <table  style="width:95%; border:0px;">
        <tr>
            <td>
<?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
            <?php echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos_todos, 'selected' => $periodo, 'empty' => array('0' => 'Período'))); ?>
            <?php // echo $this->Form->end(); ?>
            </td>
            <td>
<?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('nivel', array('type' => 'select', 'options' => array('1' => 'OTP 1', '2' => 'OTP 2', '3' => 'OTP 3', '4' => 'OTP 4'), 'selected' => $nivel, 'default' => 0, 'empty' => array('0' => 'OTP'))); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
            <td>
                    <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('turno', array('type' => 'select', 'options' => array('D' => 'Diurno', 'N' => 'Noturno'), 'selected' => $turno, 'empty' => array('0' => 'Turno'))); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
            <td> 
<?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_area', array('type' => 'select', 'options' => $areas, 'selected' => $id_area, 'empty' => array('0' => 'Seleciona área'))); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
        </tr>
    </table>

    <table style="width:95%; border:0px">
        <tr>
            <td> 
<?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_professor', array('type' => 'select', 'options' => $professores, 'selected' => $id_professor, 'default' => 0, 'empty' => array('0' => 'Seleciona professor'))); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
            <td> 
<?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_supervisor', array('type' => 'select', 'options' => $supervisores, 'selected' => $id_supervisor, 'default' => 0, 'empty' => array('0' => 'Seleciona supervisor'))); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
            <td> 
<?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_instituicao', array('type' => 'select', 'options' => $instituicoes, 'selected' => $id_instituicao, 'default' => 0, 'empty' => array('0' => 'Seleciona instituição'), 'style'=>'width: 25em')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
        </tr>
    </table>
</div>

<div align='center'>

<?php ($periodo == 0 ? $periodo = "Todos" : $periodo = $periodo); ?>
    <h1>Estagiarios período: <?php echo $periodo; ?></h1>

<?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->prev('< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->next(' Posterior > ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

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
        <?php foreach ($estagiarios as $aluno): ?>
    <tr>
        <?php if ($this->Session->read('categoria') != 'estudante'): ?>
        <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'], "/alunos/view/" . $aluno['Aluno']['id']); ?></td>
            <?php endif; ?>    
        <td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>
        <td style='text-align:center'><?php echo $aluno['Estagiario']['periodo']; ?></td>
        <td style='text-align:center'><?php echo $aluno['Estagiario']['nivel']; ?></td>
        <td style='text-align:center'><?php echo $aluno['Estagiario']['turno']; ?></td>
        <td style='text-align:center'><?php echo $aluno['Estagiario']['tc']; ?></td>
    <?php if ($this->Session->read('categoria') != 'estudante'): ?>
        <td style='text-align:left'><?php echo $this->Html->link($aluno['Instituicao']['instituicao'], "/instituicaos/view/" . $aluno['Estagiario']['id_instituicao']); ?></td>
        <td style='text-align:left'><?php echo $this->Html->link($aluno['Supervisor']['nome'], "/supervisors/view/" . $aluno['Estagiario']['id_supervisor']); ?></td>
        <td style='text-align:left'><?php echo $this->Html->link($aluno['Professor']['nome'], "/professors/view/" . $aluno['Estagiario']['id_professor']); ?></td>
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

<?php
echo $this->Paginator->counter(array(
    'format' => "Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
));
?>
