<h1>Áreas das instituições</h1>

<?php echo $this->Html->link($area['AreaInstituicao']['id'], '/Instituicaos/index/area_instituicoes_id:' . $area['AreaInstituicao']['id']); ?>
<?php echo ' | '; ?>
<?php echo $this->Html->link($area['AreaInstituicao']['area'], '/Instituicaos/index/area_instituicoes_id:' . $area['AreaInstituicao']['id']); ?>

<br />

<?php 

if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3'):

echo $this->Html->link('Excluir','/AreaInstituicaos/delete/' . $area['AreaInstituicao']['id'], NULL, 'Tem certeza?');
echo ' | ';
echo $this->Html->link('Editar','/AreaInstituicaos/edit/' . $area['AreaInstituicao']['id']);

endif; 

?>
