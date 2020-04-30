<p>Alunos novos sem inscrições no mural</p>

<?php if (!empty($orfaos)): ?>

<table>

<?php foreach ($orfaos as $c_orfaos): ?>

    <tr>

    <td>
    <?php echo $c_orfaos['Estudante']['id']; ?>
    </td>

    <td>
    <?php echo $c_orfaos['Estudante']['registro']; ?>
    </td>

    <td>
    <?php echo $this->Html->link($c_orfaos['Estudante']['nome'], '/Estudantes/view/'. $c_orfaos['Estudante']['id']); ?>
    </td>

    <td>
    <?php echo $c_orfaos['Estudante']['celular']; ?>
    </td>

    <td>
    <?php echo $c_orfaos['Estudante']['email']; ?>
    </td>

    <td>
    <?php echo $this->Html->link('X', '/Estudantes/delete/'. $c_orfaos['Estudante']['id'], null, 'Tem certeza?'); ?>
    </td>

    </tr>

<?php endforeach; ?>

</table>

<?php else: ?>

<p>Não há alunos novos sem inscrições no mural: <?php echo $this->Html->link('voltar', '/Murals/index/'); ?></p>

<?php endif; ?>
