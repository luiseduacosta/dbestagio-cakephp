<?php // pr($seminstituicao);  ?>

<?= $this->element('submenu_supervisores') ?>

<?php if ($seminstituicao): ?>

    <table>
        <caption>Supervisores sem instituição cadastrada</caption>
        <tr>
            <th>CRESS</th>
            <th>Nome</th>
            <th>Estagiários</th>
        </tr>
        <?php foreach ($seminstituicao as $c_seminstituicao): ?>
                <tr>
                    <td><?= $this->Html->link($c_seminstituicao['cress'], ['controller' => 'Supervisores', 'action' => 'view/cress:' . $c_seminstituicao['cress']]); ?></td>
                    <td><?= $this->Html->link($c_seminstituicao['nome'], ['controller' => 'Supervisores', 'action' => 'view', $c_seminstituicao['supervisor_id']]) ?></td>
                    <td><?php echo $c_seminstituicao['q_estagiarios']; ?></td>
                </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>