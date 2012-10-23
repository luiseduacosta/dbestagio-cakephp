<p>Alunos novos sem inscrições no mural</p>

<?php if (!empty($orfaos)): ?>

<table>
    
<?php foreach ($orfaos as $c_orfaos): ?>

    <tr>

    <td>
    <?php echo $c_orfaos['Alunonovo']['id']; ?>
    </td>

    <td>
    <?php echo $c_orfaos['Alunonovo']['registro']; ?>
    </td>
    
    <td>
    <?php echo $this->Html->link($c_orfaos['Alunonovo']['nome'], '/alunonovos/view/'. $c_orfaos['Alunonovo']['id']); ?>
    </td>

    <td>
    <?php echo $c_orfaos['Alunonovo']['celular']; ?>
    </td>    
    
    <td>
    <?php echo $c_orfaos['Alunonovo']['email']; ?>
    </td>
    
    <td>
    <?php echo $this->Html->link('X', '/alunonovos/delete/'. $c_orfaos['Alunonovo']['id'], NULL, 'Tem certeza?'); ?>
    </td>

    </tr>
    
<?php endforeach; ?>

</table>

<?php else: ?>

<p>Não há alunos novos sem inscrições no mural: <?php echo $this->Html->link('voltar', '/murals/index/'); ?></p>

<?php endif; ?>