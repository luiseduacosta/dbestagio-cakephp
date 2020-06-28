<?php
// pr($supervisores);
// die();
echo $this->element('submenu_supervisores');
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

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Supervisor'); ?>
    <div class='form-group row'>
        <label for='SupervisorPeriodo' class='col-sm-1 col-form-label'>Período</label>
        <div class='col-sm-2'>
            <?php echo $this->Form->input('periodo', array('label' => false, 'type' => 'select', 'label' => false, 'options' => $todosPeriodos, 'default' => $periodo, 'empty' => 'Selecione', 'class' => 'form-control')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
<?php endif; ?>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <div class='table-responsive'>
            <table class="table table-striped table-hover table-responsive">
                <thead class="thead-light">
                    <tr>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <th width='10%'><?= $this->Html->link('CRESS', '/Supervisores/index/ordem:cress') ?></th>
                        <?php endif; ?>
                        <th width='50%'><?= $this->Html->link('Nome', '/Supervisores/index/ordem:nome') ?></th>
                        <th><?= $this->Html->link('Quantidade de períodos', '/Supervisores/index/ordem:q_periodos') ?></th>
                        <th><?= $this->Html->link('Quantidade de estudantes', '/Supervisores/index/ordem:q_estudantes') ?></th>
                        <th><?= $this->Html->link('Quantidade de estagiários', '/Supervisores/index/ordem:q_estagiarios') ?></th>
                        <th><?= $this->Html->link('Último período', '/Supervisores/index/ordem:periodo') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($supervisores as $c_supervisor): ?>

                        <?php // echo $c_supervisor['Estagiario'][count($c_supervisor['Estagiario'])-1]['periodo'] ?>
                        <tr>

                            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                <td>
                                    <?php echo $c_supervisor['cress']; ?>
                                </td>
                            <?php endif; ?>

                            <td>
                                <?php
                                if ($c_supervisor['nome']):
                                    echo $this->Html->link($c_supervisor['nome'], '/Supervisores/view/' . $c_supervisor['id']);
                                else:
                                    echo "Sem dados";
                                endif;
                                ?>
                            </td>
                            <td><?= $c_supervisor['q_periodos'] ?></td>
                            <td><?= $c_supervisor['q_estudantes'] ?></td>
                            <td><?= $this->Html->link($c_supervisor['q_estagiarios'], '/Estagiarios/index/supervisor_id:' . $c_supervisor['id'] . '/periodo:' . 0) ?></td>
                            <td><?= $c_supervisor['periodo'] ?></td>
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
