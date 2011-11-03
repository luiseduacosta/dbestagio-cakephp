<?php

// pr($usuario);

echo 'Id: ' . $usuario['ArosAco']['id'] . '<br>';
echo 'Categoria: ' .$categoria . '<br>';
echo 'Objeto: ' . $objeto . '<br>';
echo 'Crear: ' . $usuario['ArosAco']['_create'] . '<br>';
echo 'Ler: ' . $usuario['ArosAco']['_read'] . '<br>'; 
echo 'Editar: ' . $usuario['ArosAco']['_update'] . '<br>';
echo 'Excluir: ' . $usuario['ArosAco']['_delete'] . '<br>';

echo '<br>';

echo $html->link('Voltar', '/aros/indexaros/') . " ";
echo $html->link('Editar', '/aros/editaros/' . $usuario['ArosAco']['id']);

?>