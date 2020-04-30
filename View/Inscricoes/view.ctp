<?php
// pr($inscricao);
?>
<?php echo $this->Html->link('Listar', '/Inscricoes/index/'); ?>

<h1>Inscrição para seleção de estágio</h1>

<table>

<tr>
<td>Registro</td>
<td><?php echo $inscricao[0]['Inscricao']['aluno_id']; ?></td>
</tr>

<tr>
<td>Nome</td>
<td>
<?php
if ($inscricao[0]['Aluno']['nome']) {
echo strtoupper($inscricao[0]['Aluno']['nome']);
} else {
echo strtoupper($inscricao[0]['Estudante']['nome']);
}
?>
</td>
</tr>

<tr>
<td>Instituição</td>
<td><?php echo $inscricao[0]['Muralestagio']['instituicao']; ?></td>
</tr>

<tr>
<td>Data</td>
<td><?php echo (date('d-m-Y', strtotime($inscricao[0]['Inscricao']['data']))); ?></td>
</tr>

<tr>
<td>Período</td>
<td><?php echo $inscricao[0]['Inscricao']['periodo']; ?></td>
</tr>

</table>

<hr>

<?php echo $this->Html->link('Excluir', '/Inscricoes/delete/' . $inscricao[0]['Inscricao']['id'], NULL, 'Tem certeza?'); ?>
