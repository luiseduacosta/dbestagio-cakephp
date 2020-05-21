<?php // pr($semalunos); ?>
<?php // die(); ?>

<?= $this->element('submenu_supervisores') ?>

<?php $i = 1; ?>
<table>
    <caption>Supervisores sem estagiários</caption>
    <tr>
        <th>Id</th>
        <th>CRESS</th>
        <th>Nome</th>
    </tr>
    <?php foreach ($semalunos as $c_semalunos): ?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $c_semalunos['cress']; ?></td>
        <td><?php echo $this->Html->link($c_semalunos['nome'], '/supervisores/view/'. $c_semalunos['id']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>