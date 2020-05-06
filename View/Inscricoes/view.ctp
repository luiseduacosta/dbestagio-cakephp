<?php
// pr($inscricao);
?>
<?php echo $this->Html->link('Listar', '/Inscricoes/index/'. $inscricao[0]['Inscricao']['mural_estagio_id']); ?>

<h1>Inscrição para seleção de estágio</h1>

<table>

<tr>
<td>Registro</td>
<td><?php echo $inscricao[0]['Inscricao']['aluno_id']; ?></td>
</tr>

<tr>
<td>Nome</td>
<td>
<?= strtoupper($inscricao[0]['Estudante']['nome']); ?>
</td>
</tr>

<tr>
<td>Instituição</td>
<td><?= $inscricao[0]['Muralestagio']['instituicao']; ?></td>
</tr>

<tr>
<td>Data</td>
<td><?= (date('d-m-Y', strtotime($inscricao[0]['Inscricao']['data']))); ?></td>
</tr>

<tr>
<td>Período</td>
<td><?= $inscricao[0]['Inscricao']['periodo']; ?></td>
</tr>

</table>

<hr>

<?php
if ($this->Session->read('id_categoria') === '1'): ?>
<?= $this->Html->link('Excluir', '/Inscricoes/delete/' . $inscricao[0]['Inscricao']['id'], NULL, 'Tem certeza?'); ?>
<?php endif; ?>