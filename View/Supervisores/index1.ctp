<?php
// pr($supervisores);
// pr($periodo);
// die();
?>

<script>

    $(document).ready(function () {

        $("#SupervisorPeriodo").change(function () {
            var periodo = $(this).val();
            var link = "<?= $this->Html->url(["controller" => "Supervisores", "action" => "index1/periodo:"]); ?>";
            var link = link + periodo;
            /* alert(link); */
            $(location).attr('href', link);
            /* window.location=url; */
        })
    })

</script>

<?php
echo $this->element('submenu_supervisores');
?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Supervisor'); ?>
    <div class='form-group row'>
        <div class='col-sm-2'>
            <?php echo $this->Form->input('periodo', array('label' => false, 'type' => 'select', 'label' => false, 'options' => $todosPeriodos, 'default' => $periodo, 'empty' => 'Selecione período', 'class' => 'form-control')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
<?php endif; ?>

<div class='row justify-content-center'>
    <div class="col-auto">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-responsive">

                <thead class="thead-light">
                    <tr>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <th width='10%'><?= $this->Html->link('CRESS', '/Supervisores/index1/ordem:cress/periodo:' . $periodo) ?></th>
                        <?php endif; ?>
                        <th width='50%'><?= $this->Html->link('Nome', '/Supervisores/index1/ordem:nome/periodo:' . $periodo) ?></th>
                        <th><?= $this->Html->link('Estagiários no período', '/Supervisores/index1/ordem:q_estagiarios/periodo:' . $periodo) ?></th>
                        <th><?= $this->Html->link('Total de Estagiários', '/Supervisores/index1/ordem:q_totaldeestagiarios/periodo:' . $periodo) ?></th>
                        <th><?= $this->Html->link('Total de períodos ', '/Supervisores/index1/ordem:q_periodos/periodo:' . $periodo) ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($supervisores as $c_supervisor): ?>
                        <?php // pr($c_supervisor['Estagiario'][0]['periodo']); ?>

                        <tr>

                            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                <td>
                                    <?php echo $c_supervisor['cress']; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($c_supervisor['nome']):
                                        echo $this->Html->link($c_supervisor['nome'], '/Supervisores/view/' . $c_supervisor['id']);
                                    else:
                                        echo "Sem dados";
                                    endif;
                                    ?>
                                </td>
                            <?php endif; ?>
                            <td><?php echo $c_supervisor['cress']; ?></td>
                            <td><?php echo $c_supervisor['nome']; ?></td>
                            <td><?= $this->Html->link($c_supervisor['q_estagiarios'], '/Estagiarios/index/supervisor_id:' . $c_supervisor['id'] . '/periodo:' . $periodo) ?></td>
                            <td>
                                <?php echo $c_supervisor['q_totaldeestagiarios']; ?>
                            </td>
                            <td>
                                <?php echo $c_supervisor['q_periodos']; ?>
                            </td>
                        </tr>
                        <?php // pr($c_supervisor) ?>
                        <?php // die('c_supervisor') ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
<?php
/*
  echo $this->Paginator->counter(array(
  'format' => 'Página %page% de %pages%,
  exibindo %current% registros do %count% total,
  começando no registro %start%, finalizando no %end%'
  ));
 *
 */
?>
