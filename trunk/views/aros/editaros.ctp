<?php

echo "Categoria: " . $categoria . "<br>";
echo "Objeto: " . $objeto . "<br>";
echo "Id: " . $usuario['ArosAco']['id'] . "<br>";

echo $form->create('ArosAco', array('url'=>'/aros/editaros/'));
echo $form->input('_create', array('label'=>'Crear', 'default'=>1, 'options'=>array(0,1)));
echo $form->input('_read', array('label'=>'Ler', 'options'=>array(0,1)));
echo $form->input('_update', array('label'=>'Editar', 'options'=>array(0,1)));
echo $form->input('_delete', array('label'=>'Excluir', 'options'=>array(0,1)));
echo $form->input('id', array('type'=>'hidden', 'default'=>$usuario['ArosAco']['id']));
echo $form->end('Confirma');

echo '<br>';

echo $html->link('Voltar', '/aros/indexaros/');

?>