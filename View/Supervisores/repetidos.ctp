<?php // pr($repetidos);  ?>

<?php if ($repetidos): ?>

    <table>
        <caption>CRESS repetidos</caption>
        <?php foreach ($repetidos as $c_repetidos): ?>
            <?php if ($c_repetidos['Supervisor']['cress'] != 0): ?>
                <tr>
                    <td><?= $this->Html->link($c_repetidos['Supervisor']['cress'], ['controller' => 'Supervisores', 'action' => 'view/cress:' . $c_repetidos['Supervisor']['cress']]); ?></td>
                    <td><?php echo $c_repetidos['Supervisor']['nome']; ?></td>
                    <td><?php echo $c_repetidos['0']['quantidade']; ?></td>
                </tr>
            <?php endif; ?> 
        <?php endforeach; ?>
    </table>

<?php endif; ?>