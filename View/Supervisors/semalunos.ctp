<?php // pr($semalunos); ?>

<table>
    <caption>Supervisores sem estagiários</caption>
    <?php $i = 1; ?>
    <?php foreach ($semalunos as $c_semalunos): ?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $c_semalunos['Supervisor']['cress']; ?></td>
        <td><?php echo $this->Html->link($c_semalunos['Supervisor']['nome'], '/supervisors/view/'. $c_semalunos['Supervisor']['id']); ?></td>
        <td><?php
            if (!empty($c_semalunos['Instituicao']['0']['instituicao'])):
                echo $c_semalunos['Instituicao']['0']['instituicao']; 
            endif;
            ?></td>
    </tr>
    <?php endforeach; ?>
</table>