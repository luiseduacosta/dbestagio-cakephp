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

<hr/>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <p>
    <?php echo $this->Html->link('Excluir', '/Alunonovos/delete/' . $alunos['Alunonovo']['id'], NULL, 'Tem certeza?') . ' | '; ?>
    <?php echo $this->Html->link('Editar',  '/Alunonovos/edit/' . $alunos['Alunonovo']['id']); ?>
    </p>

    <hr/>

    <p>
    <?php echo $this->Html->link('Alunos novos', array('controller'=>'Alunonovos','action'=>'index')); ?> |
    <?php echo $this->Html->link('Buscar', array('controller'=>'Alunonovos','action'=>'busca')); ?>
    <br />
    <?php echo $this->Html->link('Todos os alunos', array('controller'=>'Inscricaos','action'=>'index')); ?>
    </p>
<?php endif; ?>

<?php if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero') === $alunos['Alunonovo']['registro'])): ?>
    <p>
    <?php echo $this->Html->link('Editar',  '/Alunonovos/edit/' . $alunos['Alunonovo']['id']); ?>
    </p>
<?php endif; ?>


<hr/>

<?php if ($inscricoes): ?> 
<table>
<caption>Inscrições realizadas</caption>
<?php foreach ($inscricoes as $c_inscricao): ?>
    <tr>

    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <td><?php echo $this->Html->link('X','/Inscricaos/delete/' . $c_inscricao['Inscricao']['id'], NULL, 'Confirma?'); ?></td>
        <td><?php echo $this->Html->link($c_inscricao['Mural']['instituicao'], '/Inscricaos/index/' . $c_inscricao['Mural']['id']); ?></td>
        <td><?php echo $c_inscricao['Mural']['periodo']; ?></td>
    <?php else: ?>
        <td><?php echo $this->Html->link($c_inscricao['Mural']['instituicao'], '/Inscricaos/index/' . $c_inscricao['Mural']['id']); ?></td>
        <td><?php echo $c_inscricao['Mural']['periodo']; ?></td>
    <?php endif; ?>

    </tr>
<?php endforeach; ?>
    
</table>
<?php else: ?>

<h1>Sem inscrições para seleção de estágio!</h1>

<?php endif; ?>