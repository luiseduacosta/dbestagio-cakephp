<?php echo $html->link('Listar estagiários','/Estagiarios/index'); ?>

<div align='center'>
<h1>Alunos</h1>

<?php echo $paginator->prev('<< Anterior ', null, null, array('class'=>'disabled')); ?>
<?php echo $paginator->next(' Posterior >> ', null, null, array('class'=>'disabled')); ?>

<br/>
<?php echo $paginator->numbers(); ?>
</div>

<table border=1>
<tr>
<th><?php echo $paginator->sort('Registro','registro'); ?></th>
<th><?php echo $paginator->sort('Nome','nome'); ?></th>
<th><?php echo $paginator->sort('Email','email'); ?></th>
</tr>
<?php foreach ($alunos as $aluno): ?>
<tr>
<td style='text-align:center'>
<?php echo $html->link($aluno['Aluno']['registro'], '/Alunos/view/' . $aluno['Aluno']['id']); ?>
<td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>
<td style='text-align:left'><?php echo $aluno['Aluno']['email']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php echo $paginator->counter(); ?>
