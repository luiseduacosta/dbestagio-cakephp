<?php

$this->Session->flash('auth');

echo $this->Form->create('User', array('action'=>'login'));

echo $this->Form->input('categoria', array('options'=>array('1'=>'Estudante', '2'=>'Professor', '3'=>'Supervisor')));

echo $this->Form->input('email', array('label'=>'Email', 'type'=>'text', 'size'=>'20'));

echo $this->Form->input('password');

echo $this->Form->end('Login');

echo $this->Html->link('Cadastro', '/Users/cadastro/');

?>
