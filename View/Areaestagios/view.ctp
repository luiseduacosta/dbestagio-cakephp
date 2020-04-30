<h1>Área</h1>

<?php echo $this->Html->link($area['Areaestagio']['id'], '/Estagiarios/index/areaestagio_id:' . $area['Areaestagio']['id']); ?>
<?php echo ' | '; ?>
<?php echo $this->Html->link($area['Areaestagio']['area'], '/Estagiarios/index/areaestagio_id:' . $area['Areaestagio']['id'] . '/periodo:0'); ?>

<br />

<?php

if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3'):

echo $this->Html->link('Excluir','/Areaestagios/delete/' . $area['Areaestagio']['id'], NULL, 'Tem certeza?');
echo ' | ';
echo $this->Html->link('Editar','/Areaestagios/edit/' . $area['Areaestagio']['id']);

endif;

?>
