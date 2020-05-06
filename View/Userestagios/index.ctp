<div align='center'>
<?php echo $this->Paginator->first('Primeiro', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->prev(' < ', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->next(' > ', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->last('Último', null, null, array('class' => 'disabled')); ?>

<br />

<?php echo $this->Paginator->numbers(); ?>

</div>

<table>
<thead>
<tr>
<th><?php echo $this->Paginator->sort('Userestagio.id', 'Id'); ?></th>
<th><?php echo $this->Paginator->sort('Userestagio.numero', 'Número'); ?></th>
<th><?php echo $this->Paginator->sort('Userestagio.email', 'Email'); ?></th>
<th><?php echo $this->Paginator->sort('Role.categoria', 'Categoria'); ?></th>
</tr>
</thead>

<tbody>
<?php
foreach ($usuarios as $c_usuarios) {
    ?>

<tr>
<td><?php echo $this->Html->link($c_usuarios['Userestagio']['id'], '/Userestagios/delete/' . $c_usuarios['Userestagio']['id'], null, 'Tem certeza?'); ?></td>
<td><?php echo $c_usuarios['Userestagio']['numero']; ?></td>
<td><?php echo $c_usuarios['Userestagio']['email']; ?></td>
<td><?php echo $c_usuarios['Role']['categoria']; ?></td>

</tr>

<?php
}
?>
<tbody>

</table>
