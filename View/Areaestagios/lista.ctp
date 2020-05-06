<?php /* pr($areas); */ ?>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Áreas por professor', '/Areaestagios/index/'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Inserir', '/Areaestagios/add/'); ?>
    <br />
<?php endif; ?>

<h1>Áreas de orientação dos professores de OTP</h1>
<?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->prev('< Anterior ', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->next(' Posterior > ', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

<br/>

<?php echo $this->Paginator->numbers(); ?>

<table>
    <tr>
        <th><?= $this->Paginator->sort('Areaestagio.id', 'Id') ?></th>
        <th><?= $this->Paginator->sort('Areaestagio.area', 'Área') ?></th>
    </tr>

    <?php foreach ($areas as $c_area): ?>

        <tr>
            <td>
                <?php echo $this->Html->link($c_area['Areaestagio']['id'], '/Areaestagios/view/' . $c_area['Areaestagio']['id']); ?>
            </td>
            <td>
                <?php echo $this->Html->link($c_area['Areaestagio']['area'], '/Estagiarios/index/areaestagio_id:' . $c_area['Areaestagio']['id']); ?>
            </td>
        </tr>

    <?php endforeach; ?>

</table>
<?=
$this->Paginator->counter(array(
    'format' => "Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
));
?>