<?php

echo $form->create('User', array('action'=>'login'));

echo $form->input('categoria', array('options'=>array('1'=>'Estudante', '2'=>'Professor', '3'=>'Supervisor')));

echo $form->input('email', array('label'=>'Email', 'type'=>'text', 'size'=>'20'));

echo $form->input('password', array('type'=>'password', 'size'=>'20', 'label'=>'Senha'));

echo $form->end('Login');

echo $html->link('Cadastro', '/Users/cadastro/');

?>
