<h5>Área</h5>

<div class="row">
    <div class="col-1">
        <?php echo $this->Html->link($area['Areaestagio']['id'], '/Estagiarios/index/areaestagio_id:' . $area['Areaestagio']['id']); ?>
    </div>
    <div class="col">
        <?php echo $this->Html->link($area['Areaestagio']['area'], '/Estagiarios/index/areaestagio_id:' . $area['Areaestagio']['id'] . '/periodo:0'); ?>
    </div>
</div>

<br />

<?php
if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3'):
    ?>
    <div class="nav nav-tabs">
        <?= $this->Html->link('Excluir', '/Areaestagios/delete/' . $area['Areaestagio']['id'], ['class' => 'nav-item nav-link'], 'Tem certeza?'); ?>
        <?= $this->Html->link('Editar', '/Areaestagios/edit/' . $area['Areaestagio']['id'], ['class' => 'nav-item nav-link']); ?>
    </div>
    <?php
endif;
?>
