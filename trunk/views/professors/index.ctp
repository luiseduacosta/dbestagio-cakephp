<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $html->link('Inserir', '/Professors/add/');
    echo " | ";
    echo $html->link('Buscar (não implementado)', '/Professors/busca/');
    echo " | ";
    echo $html->link('Áreas', '/Areas/index/');
    ?>
<?php else: ?>
    <?php
    echo $html->link('Buscar (não implementado)', '/Professors/busca/');
    echo " | ";
    echo $html->link('Áreas', '/Areas/index/');
    ?>
<?php endif; ?>

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
<?php echo $this->Paginator->sort('Email', 'Professor.email'); ?>
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

<?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria')) === 'professor'): ?>
    <th>
    <?php echo $this->Paginator->sort('Celular', 'Professor.celular'); ?>
    </th>
    <th>
    <?php echo $this->Paginator->sort('Egresso', 'Professor.dataegresso'); ?>
    </th>
    <th>
    <?php echo $this->Paginator->sort('Motivo', 'Professor.motivoegresso'); ?>
    </th>
<?php endif; ?>

</tr>
</thead>
<tbody>
<?php foreach ($professores as $c_professor): ?>
<tr>
<td>
<?php echo $c_professor['Professor']['siape']; ?>
</td>
<td>
<?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria') === 'professor')): ?>
    <?php echo $html->link($c_professor['Professor']['nome'], '/Professors/view/'. $c_professor['Professor']['id']); ?>
<?php else: ?>
    <?php echo $c_professor['Professor']['nome']; ?>
<?php endif; ?>
</td>
<td>
<?php echo $c_professor['Professor']['email']; ?>
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

<?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria')) === 'professor'): ?>
    <td>
    <?php echo $c_professor['Professor']['celular']; ?>
    </td>
    <td>
    <?php echo $c_professor['Professor']['dataegresso']; ?>
    </td>
    <td>
    <?php echo $c_professor['Professor']['motivoegresso']; ?>
    </td>
<?php endif; ?>

</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>