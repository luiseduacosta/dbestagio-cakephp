<?php

$session->flash('auth');
echo $form->create('User', array('action'=>'login'));
echo $form->input('username', array('type'=>'text', 'size'=>'20',
'label'=>'Login'));
echo $form->input('password', array('type'=>'password', 'size'=>'20',
'label'=>'Senha'));
echo $form->end('Login');

?>
