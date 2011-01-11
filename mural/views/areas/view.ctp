<h1>Área</h1>

<?php echo $html->link($area['Area']['area'], '/Estagiarios/index/id_area:' . $area['Area']['id']); ?>

<br />

<?php

echo $html->link('Excluir','/Areas/delete/' . $area['Area']['id'], NULL, 'Tem certeza?');
echo ' | ';
echo $html->link('Editar','/Areas/edit/' . $area['Area']['id']);

?>