<?php // pr($professores);     ?>

<?php echo $this->element('submenu_professores'); ?>

<script>

    $(document).ready(function () {

        var url = "<?= $this->Html->url(['controller' => 'Professores', 'action' => 'pauta/periodo:']) ?>";

        $("#ProfessorPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = url + periodo;
        })

    })
</script>


<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Professor'); ?>
    <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => ['text' => 'Período', 'class' => 'col-lg-1 col-form-label'], 'options' => $todosPeriodo, 'default' => $periodo, 'div' => 'form-group row', 'class' => 'form-horizontal')); ?>
    <?php echo $this->Form->end(); ?>
<?php else: ?>
    <h5>Pauta: <?php echo $periodo; ?></h5>
<?php endif; ?>


<?php if (isset($professores) && !empty($professores)): ?>    

    <?php $total = NULL; ?>
    <div class='row justify-content-center'>
        <div class='col-auto'>
            <div class="container table-responsive">
                <table class="table table-striped table-hover table-responsive">
                    <caption>Pauta: <?php echo $this->Html->link($periodo, '/Estagiarios/index/periodo:' . $periodo); ?></caption>
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo 'Professor'; ?></th>
                            <th><?php echo 'Departamento'; ?></th>
                            <th><?php echo 'Turma'; ?></th>
                            <th><?php // echo 'Turno';     ?></th>
                            <th><?php echo 'Turma'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($professores as $c_professores): ?>
                            <tr>
                                <td><?php echo $this->Html->link($c_professores['professor'], '/Estagiarios/index/docente_id:' . $c_professores['docente_id'] . '/periodo:' . $periodo); ?></td>
                                <td><?php echo $c_professores['departamento']; ?></td>
                                <td><?php
                                    if ($c_professores['area']) :
                                        echo $c_professores['area'];
                                    endif;
                                    ?></td>
                                <td><?php // echo $c_professores['periodo'];    ?></td>
                                <td><?php echo $c_professores['estagiariosperiodo']; ?></td>
                            </tr>
                            <?php $total += $c_professores['estagiariosperiodo']; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td>Total estudantes</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $total; ?></td>
                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>

        <?php else: ?>
            <?php echo "Sem pauta para o período"; ?>    
        <?php endif; ?>
    </div>
</div>