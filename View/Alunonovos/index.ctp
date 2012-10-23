<div align='center'>
<h1>Alunos novos</h1>

<table border=1>
<?php foreach ($alunonovo as $c_aluno): ?>
<?php if ($c_aluno['Alunonovo']['id']) {; ?>
<tr>
<td style='text-align:center'>
<?php echo $this->Html->link($c_aluno['Alunonovo']['registro'], '/Alunonovos/view/' . $c_aluno['Alunonovo']['id']); ?>
<td style='text-align:left'><?php echo $c_aluno['Alunonovo']['nome']; ?></td>
<td style='text-align:left'><?php echo $c_aluno['Alunonovo']['email']; ?></td>
</tr>
<?php }; ?>
<?php endforeach; ?>
</table>
</div>