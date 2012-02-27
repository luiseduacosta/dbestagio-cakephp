<?php echo $html->link('Listar mural', '/murals/index'); ?>

<hr />

<h1>Estudantes inscritos para estágio</h1>

<?php if (isset($instituicao)): ?>
<h1><?php echo $html->link($instituicao, '/murals/view/' . $mural_id); ?></h1>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <th><a href="?ordem=id">Id</a></th>
                <th><a href="?ordem=id_aluno">DRE</a></th>
                <th><a href="?ordem=tipo">T</a></th>
                <th><a href="?ordem=nome">Estudante</a></th>
                <th><a href="?ordem=nascimento">Nascimento</a></th>
                <th><a href="?ordem=telefone">Telefone</a></th>
                <th><a href="?ordem=celular">Celular</a></th>
                <th><a href="?ordem=email">Email</a></th>
            <?php else: ?>
                <th><a href="?ordem=nome">Estudante</a></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($inscritos as $c_inscrito): ?>
        <tr>
            
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <td><?php echo $html->link($c_inscrito['id_inscricao'], '/inscricaos/view/' . $c_inscrito['id_inscricao']); ?></td>
                <td><?php echo $c_inscrito['id_aluno']; ?></td>
                <td><?php echo $c_inscrito['tipo']; ?></td>
            <?php endif; ?>
            
            <td>
            <?php 
			if ($c_inscrito['tipo'] === 0) {
                            if ($this->Session->read('categoria') === 'administrador') {
				echo $html->link($c_inscrito['nome'], '/Alunonovos/view/' . $c_inscrito['id']); 
                            } else {
                                echo $c_inscrito['nome'];
                            }
			} else {
                            if ($this->Session->read('categoria') === 'administrador') {
				echo $html->link($c_inscrito['nome'], '/Alunos/view/' . $c_inscrito['id']);
                            } else {
                                echo $c_inscrito['nome'];
                            }
			}
	    ?>
            </td>

            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <td><?php echo $c_inscrito['nascimento']; ?></td>
                <td><?php echo $c_inscrito['telefone']; ?></td>
                <td><?php echo $c_inscrito['celular']; ?></td>
                <td><?php echo $c_inscrito['email']; ?></td>
            <?php endif; ?>    
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>