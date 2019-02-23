<?php

echo "Categoria: " . $categoria . "<br>";
echo "Objeto: " . $objeto . "<br>";
echo "Id: " . $usuario['ArosAco']['id'] . "<br>";

echo $this->Form->create('ArosAco', array('url'=>'/aros/editaros/'));
echo $this->Form->input('_create', array('label'=>'Crear', 'default'=>1, 'options'=>array(0,1)));
echo $this->Form->input('_read', array('label'=>'Ler', 'options'=>array(0,1)));
echo $this->Form->input('_update', array('label'=>'Editar', 'options'=>array(0,1)));
echo $this->Form->input('_delete', array('label'=>'Excluir', 'options'=>array(0,1)));
echo $this->Form->input('id', array('type'=>'hidden', 'default'=>$usuario['ArosAco']['id']));
echo $this->Form->end('Confirma');

echo '<br>';

echo $this->Html->link('Voltar', '/aros/indexaros/');

?>