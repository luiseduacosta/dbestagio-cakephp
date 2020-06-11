<h1>Áreas das instituições</h1>

<?php echo $this->Html->link($area['Areainstituicao']['id'], '/Instituicoes/index/areainstituicoes_id:' . $area['Areainstituicao']['id']); ?>
<?php echo ' | '; ?>
<?php echo $this->Html->link($area['Areainstituicao']['area'], '/Instituicoes/index/areainstituicoes_id:' . $area['Areainstituicao']['id']); ?>

<br />

<?php

if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3'):

echo $this->Html->link('Excluir','/Areainstituicoes/delete/' . $area['Areainstituicao']['id'], NULL, 'Tem certeza?');
echo ' | ';
echo $this->Html->link('Editar','/Areainstituicoes/edit/' . $area['Areainstituicao']['id']);

endif;

?>
