<?php

// pr($usuario);
// pr($aluno);
// pr($alunonovo);
// pr($professor);
// pr($supervisor);
?>

<table>
    <thead>
    <th>Tabela</th>
    <th>Nome</th>
    <th>Número</th>
    <th>E-mail</th>
    </thead>
    
    <?php if (isset($aluno) && !(empty($aluno))): ?>

    <tr>
        <td>Estagiário</td>
        <td><?php echo $aluno['Aluno']['nome']; ?></td>
        <td><?php echo $this->Html->link($aluno['Aluno']['registro'], '/alunos/view/' . $aluno['Aluno']['id']); ?></td>
        <td><?php echo $aluno['Aluno']['email']; ?></td>
    </tr>

    <?php elseif (isset($alunonovo) && !(empty($alunonovo))): ?> 

    <tr>
        <td>Estudante sem estágio</td>
        <td><?php echo $alunonovo['Alunonovo']['nome']; ?></td>
        <td><?php echo $alunonovo['Alunonovo']['registro']; ?></td>
        <td><?php echo $alunonovo['Alunonovo']['email']; ?></td>
    </tr>

    <?php elseif (isset($professor) && !(empty($professor))): ?> 

    <tr>
        <td>Professor</td>
        <td><?php echo $professor['Professor']['nome']; ?></td>
        <td><?php echo $professor['Professor']['siape']; ?></td>
        <td><?php echo $professor['Professor']['email']; ?></td>
    </tr>

    <?php elseif (isset($supervisor) && !(empty($supervisor))): ?> 

    <tr>
        <td>Supervisor</td>
        <td><?php echo $supervisor['Supervisor']['nome']; ?></td>
        <td><?php echo $supervisor['Supervisor']['cress']; ?></td>
        <td><?php echo $supervisor['Supervisor']['email']; ?></td>
    </tr>

    <?php endif; ?>

    <tr>
        <td>Usuário</td>
        <td></td>
        <td><?php echo $this->Html->link($usuario['User']['numero'], '/users/edit/' . $usuario['User']['id']); ?></td>
        <td><?php echo $usuario['User']['email']; ?></td>
    </tr>

</table>
