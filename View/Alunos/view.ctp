<?php echo $this->Html->link('Alunos', '/Alunos/index'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Estagiários', '/Estagiarios/index'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Usuários', '/Aros/listausuarios'); ?>
<?php endif; ?>

<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <div align="center">
    <?php echo $this->Html->link('Retroceder', array('action'=>'view', $registro_prev)) . " "; ?> |
    <?php echo $this->Html->link('Avançar'   , array('action'=>'view', $registro_next)); ?>
    </div>
<?php endif; ?>

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
<td style='text-align:left'>Carteira de identidade: <?php echo $alunos['identidade']; ?></td>
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
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Excluir', '/Alunos/delete/' . $alunos['id'], NULL, 'Tem certeza?'); ?>
    <?php echo " | "; ?>
<?php endif; ?>

<?php if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero') === $alunos['registro'])): ?>
    <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $alunos['id']); ?>
<?php elseif ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $alunos['id']); ?>
<?php endif; ?>
</p>

<hr/>

<div align="center">
<h2>Estágios cursados</h2>
</div>

<table border='1'>
<tr>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <th>Excluir</th>
    <th>Editar</th>
<?php endif; ?>

<th>Período</th>
<th>Nível</th>
<th>Turno</th>
<th>TC</th>
<th>Instituição</th>
<th>Supervisor</th>
<th>Professor</th>
<th>Área</th>

<th>Nota</th>
<th>CH</th>
</tr>

<?php foreach ($instituicoes as $c_estagio): ?> 
<tr>
    
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <td>
    <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
    </td>
    <td>
    <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_estagio['Estagiario']['id']); ?>
    </td>
<?php endif; ?>

<td><?php echo $c_estagio['Estagiario']['periodo'] ?></td>
<td style='text-align:center'><?php echo $c_estagio['Estagiario']['nivel']; ?></td>
<td style='text-align:center'><?php echo $c_estagio['Estagiario']['turno']; ?></td>
<td style='text-align:center'><?php echo $c_estagio['Estagiario']['tc']; ?></td>
<td><?php echo $this->Html->link($c_estagio['Instituicao']['instituicao'], '/Instituicaos/view/' . $c_estagio['Instituicao']['id']); ?></td>
<td><?php echo $this->Html->link($c_estagio['Supervisor']['nome'], '/Supervisors/view/' . $c_estagio['Supervisor']['id']); ?></td>
<td><?php echo $this->Html->link($c_estagio['Professor']['nome'], '/Professors/view/' . $c_estagio['Professor']['id']); ?></td>
<td><?php echo $this->Html->link($c_estagio['Area']['area'], '/Areas/view/' . $c_estagio['Area']['id']); ?></td>
<td style='text-align:center'><?php echo $c_estagio['Estagiario']['nota']; ?></td>
<td style='text-align:center'><?php echo $c_estagio['Estagiario']['ch']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>
<?php echo $this->Html->link('Listar', array('controller'=>'Estagiarios','action'=>'index')); ?> |
<?php echo $this->Html->link('Buscar', array('controller'=>'Alunos','action'=>'busca')); ?>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link("Inserir estágio",array('controller'=>'Estagiarios','action'=>'add',$alunos['id'])); ?>
<?php endif; ?>
</p>
