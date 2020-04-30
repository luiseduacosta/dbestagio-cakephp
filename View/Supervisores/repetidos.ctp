<?php // pr($repetidos); ?>

<?php if ($repetidos): ?>

<table>
    <caption>CRESS repetidos</caption>
    <?php foreach ($repetidos as $c_repetidos): ?>
    <tr>
        <td><?php echo $c_repetidos['Supervisor']['cress']; ?></td>
        <td><?php echo $c_repetidos['Supervisor']['nome']; ?></td>
        <td><?php echo $c_repetidos['0']['quantidade']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>