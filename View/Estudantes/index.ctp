<div align='center'>
<h1>Estudantes</h1>

<table border=1>
<?php foreach ($alunonovo as $c_aluno): ?>
<?php if ($c_aluno['Estudante']['id']) {; ?>
<tr>
<td style='text-align:center'>
<?php echo $this->Html->link($c_aluno['Estudante']['registro'], '/Estudantes/view/' . $c_aluno['Estudante']['registro']); ?>
<td style='text-align:left'><?php echo $c_aluno['Estudante']['nome']; ?></td>
<td style='text-align:left'><?php echo $c_aluno['Estudante']['email']; ?></td>
</tr>
<?php }; ?>
<?php endforeach; ?>
</table>
</div>
