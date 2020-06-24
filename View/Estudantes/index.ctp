<?php
// pr($estudantes);
?>

<?= $this->element('submenu_estudantes'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">

            <h5>Estudantes</h5>

            <?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->prev('< Anterior ', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->next(' Posterior > ', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

            <br/>

            <?php echo $this->Paginator->numbers(); ?>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">

            <div class='container table-responsive'>
                <table class='table table-striped table-hover table-responsive'>
                    <caption>Tabela de estudantes</caption>
                    <thead class="thead-light">
                        <tr>
                            <th><?= $this->Paginator->sort('Estudante.id', 'DRE') ?></th>
                            <th><?= $this->Paginator->sort('Estudante.nome', 'Nome') ?></th>
                            <?php if ($this->Session->read('id_categoria') === '1'): ?>
                                <th><?= $this->Paginator->sort('Estudante.email', 'E-mail') ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudantes as $c_estudante): ?>
                            <?php
                            if ($c_estudante['Estudante']['id']) {
                                ;
                                ?>
                                <tr>
                                    <td style='text-align:center'>
                                        <?php echo $this->Html->link($c_estudante['Estudante']['registro'], '/Estudantes/view/' . $c_estudante['Estudante']['registro']); ?>
                                    <td style='text-align:left'><?php echo $c_estudante['Estudante']['nome']; ?></td>
                                    <?php if ($this->Session->read('id_categoria') === '1'): ?>
                                        <td style='text-align:left'><?php echo $c_estudante['Estudante']['email']; ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php }; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->Paginator->counter(array(
    'format' => "Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
));
?>