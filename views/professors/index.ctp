<?php

echo $html->link('Inserir', '/Professors/add/');
echo " | ";
echo $html->link('Buscar', '/Professors/busca/');
echo " | ";
echo $html->link('Áreas', '/Areas/index/');

?>

<div align="center">
<?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->prev('< Anterior ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->next(' Posterior > ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->last(' Último >> ', null, null, array('class'=>'disabled')); ?>

<br />

<?php echo $this->Paginator->numbers(); ?>
</div>

<table>
<thead>
<tr>
<th>
<?php echo $this->Paginator->sort('Siape', 'Professor.siape'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Nome', 'Professor.nome'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Lattes', 'Professor.curriculolattes'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Departamento', 'Professor.departamento'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Tipo', 'Professor.tipocargo'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Celular', 'Professor.celular'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Egresso', 'Professor.dataegresso'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Motivo', 'Professor.motivoegresso'); ?>
</th>
</tr>
</thead>
<tbody>
<?php foreach ($professores as $c_professor): ?>
<tr>
<td>
<?php echo $c_professor['Professor']['siape']; ?>
</td>
<td>
<?php echo $html->link($c_professor['Professor']['nome'], '/Professors/view/'. $c_professor['Professor']['id']); ?>
</td>
<td>
	<?php 
	if ($c_professor['Professor']['curriculolattes']) {
		echo $html->link('Lattes', $c_professor['Professor']['curriculolattes']); 
	} else {
		echo "Sem lattes";
	}
	?>
</td>
<td>
<?php echo $c_professor['Professor']['departamento']; ?>
</td>
<td>
<?php echo $c_professor['Professor']['tipocargo']; ?>
</td>
<td>
<?php echo $c_professor['Professor']['celular']; ?>
</td>
<td>
<?php echo $c_professor['Professor']['dataegresso']; ?>
</td>
<td>
<?php echo $c_professor['Professor']['motivoegresso']; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>