<?php

echo $this->Form->create('User');
echo $this->Form->input('email');
echo $this->Form->input('categoria', array('label' => 'Categoria: 2: Aluno, 3: Professor, 4: Supervisor'));

echo $this->Form->input('password', array('type' => 'hidden'));
echo $this->Form->input('numero', array('label' => 'Digite o DRE, SIAPE, CRESS para estudante, professor ou supervisor respectivamente'));
echo $this->Form->input('aluno_id', array('type' => 'hidden'));
echo $this->Form->input('alunonovo_id', array('type' => 'hidden'));
echo $this->Form->input('docente_id', array('type' => 'hidden'));
echo $this->Form->input('supervisor_id', array('type' => 'hidden'));

echo $this->Form->end('Atualizar');

?>