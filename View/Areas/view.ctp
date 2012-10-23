<h1>Área</h1>

<?php echo $this->Html->link($area['Area']['id'], '/Estagiarios/index/id_area:' . $area['Area']['id']); ?>
<?php echo ' | '; ?>
<?php echo $this->Html->link($area['Area']['area'], '/Estagiarios/index/id_area:' . $area['Area']['id'] . '/periodo:0'); ?>

<br />

<?php 

if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3'):

echo $this->Html->link('Excluir','/Areas/delete/' . $area['Area']['id'], NULL, 'Tem certeza?');
echo ' | ';
echo $this->Html->link('Editar','/Areas/edit/' . $area['Area']['id']);

endif; 

?>