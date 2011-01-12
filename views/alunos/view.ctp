
<?php echo $html->link('Retroceder', array('action'=>'view', $registro_prev)) . " "; ?> |
<?php echo $html->link('Avançar'   , array('action'=>'view', $registro_next)); ?>

<div align="center">
<h1><?php echo $alunos['nome']; ?></h1>
</div>

<?php

if (is_null($alunos['nascimento'])) {
    $nascimento = 'Sem dados';
} elseif ($alunos['nascimento'] == 0) {
    $nascimento = 'Sem informação';
} else {
    $nascimento = date('d-m-Y', strtotime($alunos['nascimento']));
}

?>

<table border='1'>
<tr>
<td style='text-align:left'>Registro: <?php echo $alunos['registro']; ?></td>
<td style='text-align:left'>CPF: <?php echo $alunos['cpf']; ?></td>
<td style='text-align:left'>Cartera de identidade: <?php echo $alunos['identidade']; ?></td>
<td style='text-align:left'>Orgão: <?php echo $alunos['orgao']; ?></td>
</tr>
<tr>
<td style='text-align:left'>Nascimento: <?php echo $nascimento; ?></td>
<td style='text-align:left'>Email: <?php echo $alunos['email']; ?></td>
<td style='text-align:left'>Telefone: <?php echo "(".$alunos['codigo_telefone'].")".$alunos['telefone']; ?></td>
<td style='text-align:left'>Celular: <?php echo "(".$alunos['codigo_celular'].")".$alunos['celular']; ?></td>
</tr>
<tr>
<td style='text-align:left'>Endereço: <?php echo $alunos['endereco']; ?></td>
<td style='text-align:left'>Bairro: <?php echo $alunos['bairro']; ?></td>
<td style='text-align:left'>Municipio: <?php echo $alunos['municipio']; ?>
<td style='text-align:left'>CEP: <?php echo $alunos['cep']; ?></td>
</tr>
</table>

<p>
<?php echo $html->link('Excluir', '/Alunos/delete/' . $alunos['id'], NULL, 'Tem certeza?'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Editar', '/Alunos/edit/' . $alunos['id']); ?>
</p>

<hr/>

<div align="center">
<h2>Estágios cursados</h2>
</div>

<table border='1'>
<tr>
<th>Excluir</th>
<th>Editar</th>
<th>Período</th>
<th>Nível</th>
<th>Turno</th>
<th>Instituição</th>
<th>Supervisor</th>
<th>Professor</th>
<th>Área</th>
<th>Nota</th>
<th>CH</th>
</tr>
<?php foreach ($instituicoes as $c_estagio): ?> 
<tr>
<td>
<?php echo $html->link('Excluir', '/Estagiarios/delete/' . $c_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
</td>
<td>
<?php echo $html->link('Editar', '/Estagiarios/view/' . $c_estagio['Estagiario']['id']); ?>
</td>
<td><?php echo $c_estagio['Estagiario']['periodo'] ?></td>
<td><?php echo $c_estagio['Estagiario']['nivel']; ?></td>
<td><?php echo $c_estagio['Estagiario']['turno']; ?></td>
<td><?php echo $html->link($c_estagio['Instituicao']['instituicao'], '/Instituicaos/view/' . $c_estagio['Instituicao']['id']); ?></td>
<td><?php echo $html->link($c_estagio['Supervisor']['nome'], '/Supervisors/view/' . $c_estagio['Supervisor']['id']); ?></td>
<td><?php echo $html->link($c_estagio['Professor']['nome'], '/Professors/view/' . $c_estagio['Professor']['id']); ?></td>
<td><?php echo $html->link($c_estagio['Area']['area'], '/Areas/view/' . $c_estagio['Area']['id']); ?></td>
<td><?php echo $c_estagio['Estagiario']['nota']; ?></td>
<td><?php echo $c_estagio['Estagiario']['ch']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>
<?php echo $html->link('Listar', array('controller'=>'Estagiarios','action'=>'index')); ?> |
<?php echo $html->link('Buscar', array('controller'=>'Alunos','action'=>'busca')); ?> |
<?php echo $html->link("Inserir estágio",array('controller'=>'Estagiarios','action'=>'add',$alunos['id'])); ?>
</p>
