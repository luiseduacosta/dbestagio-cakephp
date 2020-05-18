<?php
// pr($supervisores);
// pr($periodo);
// die();
?>

<?php
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
    <?php
    echo $this->Html->link('Inserir', '/Supervisores/add/');
    echo " | ";
    echo $this->Html->link('Buscar', '/Supervisores/busca/');
    echo " || ";
    echo $this->Html->link('Repetidos', '/Supervisores/repetidos/');
    echo " | ";
    echo $this->Html->link('Sem alunos', '/Supervisores/semalunos/');
    ?>
    <br />
<?php else: ?>
    <?php
    echo $this->Html->link('Buscar', '/Supervisores/busca/');
    ?>
    <br />
<?php endif; ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Supervisor'); ?>
    <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Período ', 'style' => 'display: inline'), 'options' => $todosPeriodos, 'default' => $periodo, 'empty' => 'Selecione período')); ?>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>

<table>

    <thead>
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

</table>

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
