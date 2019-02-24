<h1>Áreas das instituições</h1>

<?php echo $this->Html->link($area['Areainstituicao']['id'], '/Instituicaos/index/area_instituicoes_id:' . $area['Areainstituicao']['id']); ?>
<?php echo ' | '; ?>
<?php echo $this->Html->link($area['Areainstituicao']['area'], '/Instituicaos/index/area_instituicoes_id:' . $area['Areainstituicao']['id']); ?>

<br />

<?php 

if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3'):

echo $this->Html->link('Excluir','/Areainstituicaos/delete/' . $area['Areainstituicao']['id'], NULL, 'Tem certeza?');
echo ' | ';
echo $this->Html->link('Editar','/Areainstituicaos/edit/' . $area['Areainstituicao']['id']);

endif; 

?>
