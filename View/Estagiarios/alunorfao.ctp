<p>Alunos sem estágios (para excluir)</p>

<?php if (!empty($orfaos)): ?>

<table>
    
<?php foreach ($orfaos as $c_orfaos): ?>

    <tr>

    <td>
    <?php echo $c_orfaos['Aluno']['id']; ?>
    </td>

    <td>
    <?php echo $c_orfaos['Aluno']['registro']; ?>
    </td>
    
    <td>
    <?php echo $this->Html->link($c_orfaos['Aluno']['nome'], '/alunos/view/'. $c_orfaos['Aluno']['id']); ?>
    </td>

    <td>
    <?php echo $c_orfaos['Aluno']['celular']; ?>
    </td>    
    
    <td>
    <?php echo $c_orfaos['Aluno']['email']; ?>
    </td>

    <td>
    <?php echo $c_orfaos['Estagiario']['periodo']; ?>
    </td>
    
    <td>
    <?php echo $this->Html->link('X', '/alunos/delete/'. $c_orfaos['Aluno']['id'], NULL, 'Tem certeza?'); ?>
    </td>

    </tr>

<?php endforeach; ?>

</table>

<?php else: ?>

<p>Não há alunos sem estágio: <?php echo $this->Html->link('retornar', '/estagiarios/index'); ?></p>

<?php endif; ?>
