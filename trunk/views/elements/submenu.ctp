<?php

// var_dump($this->Session->read('user'));
$usuario = $this->Session->read('user');

if (!empty($usuario)) {

echo "Usuário: " . $this->Html->link("<span style='color: red'>$usuario</span>", '/alunos/view/', array('escape' => FALSE)) . " logado | ";
echo $this->Html->link('Sair', '/users/logout/');

}

?>