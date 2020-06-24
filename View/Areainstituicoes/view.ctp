<h5>Áreas das instituições</h5>

<div class="row">
    <div class="col-1">
        <?php echo $this->Html->link($area['Areainstituicao']['id'], '/Instituicoes/index/areainstituicoes_id:' . $area['Areainstituicao']['id']); ?>
    </div>
    <div class="col">
        <?php echo $this->Html->link($area['Areainstituicao']['area'], '/Instituicoes/index/areainstituicoes_id:' . $area['Areainstituicao']['id']); ?>
    </div>
</div>

<br />

<?php
if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3'):
    ?>
    <nav class="nav nav-tabs">
        <?=
        $this->Html->link('Excluir', '/Areainstituicoes/delete/' . $area['Areainstituicao']['id'], ['class' => 'nav-item nav-link'], 'Tem certeza?');
        ?>
        <?=
        $this->Html->link('Editar', '/Areainstituicoes/edit/' . $area['Areainstituicao']['id'], ['class' => 'nav-item nav-link']);
        ?>
    </nav>
    <?php
endif;
?>
