<h1>Aluno: <?php echo $alunos['Alunonovo']['nome']; ?></h1>
<table border='1'>
<tr>
<td style='text-align:left'>Registro: <?php echo $alunos['Alunonovo']['registro']; ?></td>
<td style='text-align:left'>CPF: <?php echo $alunos['Alunonovo']['cpf']; ?></td>
<td style='text-align:left'>Cartera de identidade: <?php echo $alunos['Alunonovo']['identidade']; ?></td>
<td style='text-align:left'>Orgão: <?php echo $alunos['Alunonovo']['orgao']; ?></td>
</tr>
<tr style='text-align:left'>
<td style='text-align:left'>Nascimento: <?php echo date('d-m-Y', strtotime($alunos['Alunonovo']['nascimento'])); ?></td>
<td style='text-align:left'>Email: <?php echo $alunos['Alunonovo']['email']; ?></td>
<td style='text-align:left'>Telefone: <?php echo "(".$alunos['Alunonovo']['codigo_telefone'].")".$alunos['Alunonovo']['telefone']; ?></td>
<td style='text-align:left'>Celular: <?php echo "(".$alunos['Alunonovo']['codigo_celular'].")".$alunos['Alunonovo']['celular']; ?></td>
</tr>
<tr>
<td style='text-align:left'>Endereço: <?php echo $alunos['Alunonovo']['endereco']; ?></td>
<td style='text-align:left'>CEP: <?php echo $alunos['Alunonovo']['cep']; ?></td>
<td style='text-align:left'>Bairro: <?php echo $alunos['Alunonovo']['bairro']; ?></td>
<td style='text-align:left'>Municipio: <?php echo $alunos['Alunonovo']['municipio']; ?></td>
</tr>
</table>

<table>
<caption>Inscrições realizadas</caption>
<?php foreach ($alunos['Mural'] as $c_inscricao): ?>
<tr>
<td><?php echo trim($c_inscricao['instituicao']); ?></td>
<td><?php echo trim($c_inscricao['periodo']); ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>
<?php echo $html->link('Excluir', '/Alunonovos/delete/' . $alunos['Alunonovo']['id'], NULL, 'Tem certeza?'); ?> |
<?php echo $html->link('Editar',  '/Alunonovos/edit/' . $alunos['Alunonovo']['id']); ?>
</p>

<hr/>

<p>
<?php echo $html->link('Listar alunos novos', array('controller'=>'Alunonovos','action'=>'index')); ?> |
<?php echo $html->link('Buscar', array('controller'=>'Alunonovos','action'=>'busca')); ?> |
</p>
