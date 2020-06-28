<?php // pr($repetidos);     ?>

<?= $this->element('submenu_supervisores') ?>

<?php if ($repetidos): ?>

    <div class='row justify-content-center'>
        <div class='col-auto'>
            <div class='table-responsive'>
                <table class='table table-striped table-hover table-responsive'>
                    <caption>CRESS repetidos</caption>
                    <thead class="thead-light">
                        <tr>
                            <th>Cress</th>
                            <th>Nome</th>
                            <th>Repetições</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($repetidos as $c_repetidos): ?>
                            <?php if (isset($c_repetidos['cress']) || (!empty($c_repetidos['cress']))): ?>
                                <tr>
                                    <td><?= $this->Html->link($c_repetidos['cress'], ['controller' => 'Supervisores', 'action' => 'view/cress:' . $c_repetidos['cress']]); ?></td>
                                    <td><?php echo $c_repetidos['nome']; ?></td>
                                    <td><?php echo $c_repetidos['q_cress']; ?></td>
                                </tr>
                            <?php endif; ?> 
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
    <p><?= $this->Html->link('Há ' . $semcress . ' supervisores sem número de CRESS.', '/Supervisores/index/ordem:cress') ?></p>
<?php endif; ?>