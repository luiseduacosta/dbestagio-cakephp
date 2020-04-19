<?php echo $this->Html->link('Listar', '/Inscricaos/index/'); ?>

<h1>Inscrição para seleção de estágio</h1>

<table>

<tr>
<td>Registro</td>
<td><?php echo $inscricao['Inscricao']['aluno_id']; ?></td>
</tr>

<tr>
<td>Nome</td>
<td>
<?php 
if ($inscricao['Aluno']['nome']) { 
echo $inscricao['Aluno']['nome'];
} else {
echo strtoupper($inscricao['Alunonovo']['nome']);
}
?> 
</td>
</tr>

<tr>
<td>Instituição</td>
<td><?php echo $inscricao['Mural']['instituicao']; ?></td>
</tr>

<tr>
<td>Data</td>
<td><?php echo (date('d-m-Y', strtotime($inscricao['Inscricao']['data']))); ?></td>
</tr>

<tr>
<td>Período</td>
<td><?php echo $inscricao['Inscricao']['periodo']; ?></td>
</tr>

</table>

<hr>

<?php echo $this->Html->link('Excluir', '/Inscricaos/delete/' . $inscricao['Inscricao']['id'], NULL, 'Tem certeza?'); ?>
