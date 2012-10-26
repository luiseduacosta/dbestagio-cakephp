<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

$("#ProfessorPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        window.location="/mycake/Professors/pauta/periodo:"+periodo;
	})

})

', array("inline"=>false)

);

?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Professor', array('controller' => 'Professor', 'action'=>'pauta')); ?>
    <?php echo $this->Form->input('periodo', array('type'=>'select', 'label'=>array('text'=>'Período ', 'style'=>'display: inline'), 'options'=> $todosPeriodo, 'default'=>$periodo)); ?>
    <?php echo $this->Form->end(); ?>
<?php else: ?>
    <h1>Pauta: <?php echo $periodo; ?></h1>
<?php endif; ?>

<?php $total = NULL; ?>

<table>
    <caption>Pauta: <?php echo $this->Html->link($periodo, '/Estagiarios/index/periodo:' . $periodo); ?></caption>
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('Professor.nome', 'Professor'); ?></th>
            <th><?php echo $this->Paginator->sort('Professor.departamento', 'Departamento'); ?></th>
            <th><?php echo $this->Paginator->sort('Area.area', 'Área'); ?></th>
            <th><?php echo $this->Paginator->sort('Estagiario.turno', 'Turno'); ?></th>
            <th><?php echo $this->Paginator->sort('Estagiario.turma', 'Turma'); ?></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($professores as $c_professores): ?>
<tr>
    <td><?php echo $this->Html->link($c_professores['Professor']['nome'], '/Estagiarios/index/id_professor:'. $c_professores['Professor']['id'] . '/periodo:' . $periodo); ?></td>
    <td><?php echo $c_professores['Professor']['departamento']; ?></td>
    <td><?php echo $c_professores['Area']['area']; ?></td>
    <td><?php echo $c_professores['Estagiario']['turno']; ?></td>
    <td><?php echo $c_professores['Professor']['virtualAlunos']; ?></td>
</tr>
<?php $total += $c_professores['Professor']['virtualAlunos']; ?>
<?php endforeach; ?>
<tr>
    <td>Total estudantes</td>
    <td></td>
    <td></td>
    <td></td>
    <td><?php echo $total; ?></td>
</tr>
</tbody>
</table>