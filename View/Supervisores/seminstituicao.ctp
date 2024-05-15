<?php // pr($seminstituicao);     ?>

<?= $this->element('submenu_supervisores') ?>

<?php if ($seminstituicao): ?>
    <div class='row justify-content-center'>
        <div class='col-auto'>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-responsive">
                    <caption>Supervisores sem instituição cadastrada</caption>
                    <thead class="thead-light">
                        <tr>
                            <th>CRESS</th>
                            <th>Nome</th>
                            <th>Estagiários</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seminstituicao as $c_seminstituicao): ?>
                            <tr>
                                <td><?= $this->Html->link($c_seminstituicao['cress'], ['controller' => 'Supervisores', 'action' => 'view/cress:' . $c_seminstituicao['cress']]); ?></td>
                                <td><?= $this->Html->link($c_seminstituicao['nome'], ['controller' => 'Supervisores', 'action' => 'view', $c_seminstituicao['supervisor_id']]) ?></td>
                                <td><?php echo $c_seminstituicao['q_estagiarios']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>