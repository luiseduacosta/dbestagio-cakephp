<?php // pr($semalunos);    ?>
<?php // die();    ?>

<?= $this->element('submenu_supervisores') ?>

<?php $i = 1; ?>
<div class='table-responsive'>
    <table class="table table-striped table-hover table-responsive">
        <caption>Supervisores sem estagiários</caption>
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>CRESS</th>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($semalunos as $c_semalunos): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $c_semalunos['cress']; ?></td>
                    <td><?php echo $this->Html->link($c_semalunos['nome'], '/supervisores/view/' . $c_semalunos['id']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>