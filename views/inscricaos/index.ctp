<h1>Estudantes inscritos para estágio</h1>
<h1><?php echo $html->link($instituicao, '/Murals/view/' . $mural_id); ?></h1>

<?php echo $html->link('Listar mural', '/Murals/index'); ?>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>DRE</th>
            <th></th>
            <th>Estudante</th>
            <th>Nascimento</th>
            <th>Telefone</th>
            <th>Celular</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($inscritos as $c_inscrito): ?>
        <tr>
            <td><?php echo $html->link($c_inscrito['id_inscricao'], '/Inscricaos/view/' . $c_inscrito['id_inscricao']); ?></td>
            <td><?php echo $c_inscrito['id_aluno']; ?></td>
            <td><?php echo $c_inscrito['tipo']; ?></td>
            <td>
            <?php 
			if ($c_inscrito['tipo'] === 0) {
				echo $html->link($c_inscrito['nome'], '/Alunonovos/view/' . $c_inscrito['id']); 
			} else {
				echo $html->link($c_inscrito['nome'], '/Alunos/view/' . $c_inscrito['id']); 
			}
			?>
            </td>
            <td><?php echo $c_inscrito['nascimento']; ?></td>
            <td><?php echo $c_inscrito['telefone']; ?></td>
            <td><?php echo $c_inscrito['celular']; ?></td>
            <td><?php echo $c_inscrito['email']; ?></td>                        
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>