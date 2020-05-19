<?php // pr($repetidos);  ?>

<?php if ($repetidos): ?>

    <table>
        <caption>CRESS repetidos</caption>
        <?php foreach ($repetidos as $c_repetidos): ?>
            <?php if (isset($c_repetidos['cress']) || (!empty($c_repetidos['cress']))): ?>
                <tr>
                    <td><?= $this->Html->link($c_repetidos['cress'], ['controller' => 'Supervisores', 'action' => 'view/cress:' . $c_repetidos['cress']]); ?></td>
                    <td><?php echo $c_repetidos['nome']; ?></td>
                    <td><?php echo $c_repetidos['q_cress']; ?></td>
                </tr>
            <?php endif; ?> 
        <?php endforeach; ?>
    </table>
<p><?= $this->Html->link('Há ' . $semcress . ' sem número de CRESS.', '/Supervisores/index/ordem:cress') ?></p>
<?php endif; ?>