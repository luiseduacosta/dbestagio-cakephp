<?php
// pr($supervisores);
// pr($periodo);
// die();
?>

<?php
?>

<?php
echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

$("#SupervisorPeriodo").change(function() {
	var periodo = $(this).val();
        var url = window.location.pathname.split("/").slice(0,-1).join("/")+"/periodo:"+periodo;
        /* alert(url); */
        window.location=url;
    })
})

', array("inline" => false)
);
?>

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
                <th width='10%'><?= $this->Html->link('CRESS', '/Supervisores/index/ordem:cress/periodo:' . $periodo) ?></th>
            <?php endif; ?>
            <th width='50%'><?= $this->Html->link('Nome', '/Supervisores/index/ordem:nome/periodo:' . $periodo) ?></th>
            <th><?= $this->Html->link('Estagiários', '/Supervisores/index/ordem:q_estagiarios/periodo:' . $periodo) ?></th>
            <th><?= $this->Html->link('Período', '/Supervisores/index/ordem:periodo/periodo:' . $periodo) ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($supervisores as $c_supervisor): ?>
            <?php // pr($c_supervisor['Estagiario'][0]['periodo']); ?>
            <?php if ($c_supervisor['Estagiario']): ?>

                <?php // echo $c_supervisor['Estagiario'][count($c_supervisor['Estagiario'])-1]['periodo'] ?>
                <tr>

                    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                        <td>
                            <?php echo $c_supervisor['Supervisor']['cress']; ?>
                        </td>
                    <?php endif; ?>

                    <td>
                        <?php
                        if ($c_supervisor['Supervisor']['nome']):
                            echo $this->Html->link($c_supervisor['Supervisor']['nome'], '/Supervisores/view/' . $c_supervisor['Supervisor']['id']);
                        else:
                            echo "Sem dados";
                        endif;
                        ?>
                    </td>
                </tr>
                <?php // pr($c_supervisor) ?>
                <?php // die('c_supervisor') ?>
            <?php endif; ?>
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
