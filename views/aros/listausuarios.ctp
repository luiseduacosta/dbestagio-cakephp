<?php // pr($listausuarios); ?>

<?php echo $html->link('Configurações','/configuracaos/view/1'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Usuários','/aros/listausuarios/'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Permissões','/aros/indexaros/'); ?>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Número</th>
        <th>Nome</th>        
        <th>Email</th>
        <th>Categoria</th>
    </tr>
    </thead>
    
<?php foreach ($listausuarios as $usuario): ?>

<tr>
    <td>
    <?php echo $html->link($usuario['id'], '/aros/deletearos/' . $usuario['id'], NULL, 'Tem certeza?'); ?>
	</td>
    <td>
   	<?php if ($usuario['aluno_tipo'] == 0): ?>
    <?php echo $html->link($usuario['numero'], '/alunos/view/' . $usuario['aluno_id']); ?>
    <?php elseif ($usuario['aluno_tipo'] == 1): ?>
    <?php echo $html->link($usuario['numero'], '/alunonovos/view/' . $usuario['aluno_id']); ?>
    <?php elseif ($usuario['aluno_tipo'] == 2): ?>
    <?php echo $usuario['numero']; ?>
    <?php elseif ($usuario['aluno_tipo'] == 3): ?>
    <?php echo $html->link($usuario['numero'], '/professors/view/' . $usuario['aluno_id']); ?>
    <?php elseif ($usuario['aluno_tipo'] == 4): ?>
    <?php echo $html->link($usuario['numero'], '/supervisors/view/' . $usuario['aluno_id']); ?>
    <?php endif; ?>
    </td>
    <td>
    <?php echo $usuario['nome']; ?>
    </td>    
    <td>
    <?php echo $usuario['email']; ?>
    </td>
    <td>
    <?php echo $usuario['categoria']; ?>
    </td>
</tr>

<?php endforeach; ?>

</table>
