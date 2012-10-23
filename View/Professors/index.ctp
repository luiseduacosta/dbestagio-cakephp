<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Inserir', '/Professors/add/');
    echo " | ";
    echo $this->Html->link('Buscar (não implementado)', '/Professors/busca/');
    echo " | ";
    echo $this->Html->link('Áreas', '/Areas/index/');
    echo " | ";
    echo $this->Html->link('Pauta', '/Professors/pauta/');
    ?>
<?php else: ?>
    <?php
    echo $this->Html->link('Buscar (não implementado)', '/Professors/busca/');
    echo " | ";
    echo $this->Html->link('Áreas', '/Areas/index/');
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
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <th>
    <?php echo $this->Paginator->sort('Professor.siape', 'Siape'); ?>
    </th>
<?php endif; ?>
<th>
<?php echo $this->Paginator->sort('Professor.nome', 'Nome'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Professor.email', 'Email'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Professor.curriculolattes', 'Lattes'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Professor.departamento', 'Departamento'); ?>
</th>
<th>
<?php echo $this->Paginator->sort('Professor.tipocargo', 'Tipo'); ?>
</th>

<?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria')) === 'professor'): ?>
    <th>
    <?php echo $this->Paginator->sort('Professor.celular', 'Celular'); ?>
    </th>
    <th>
    <?php echo $this->Paginator->sort('Professor.dataegresso', 'Egresso'); ?>
    </th>
    <th>
    <?php echo $this->Paginator->sort('Professor.motivoegresso', 'Motivo'); ?>
    </th>
<?php endif; ?>

</tr>
</thead>
<tbody>
<?php foreach ($professores as $c_professor): ?>
<tr>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <td>
    <?php echo $c_professor['Professor']['siape']; ?>
    </td>
<?php endif; ?>
<td>
<?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria') === 'professor')): ?>
    <?php echo $this->Html->link($c_professor['Professor']['nome'], '/Professors/view/'. $c_professor['Professor']['id']); ?>
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
		echo $this->Html->link('Lattes', $c_professor['Professor']['curriculolattes']); 
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