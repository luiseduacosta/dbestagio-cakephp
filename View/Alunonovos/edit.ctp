<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->script("jquery.maskedinput", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    $("#AlunonovoRegistro").mask("999999999");
    $("#AlunonovoCpf").mask("999999999-99");
    $("#AlunonovoTelefone").mask("9999.9999");
    $("#AlunonovoCelular").mask("9999.9999");
    $("#AlunonovoCep").mask("99999-999");
    
});

', array('inline'=>false));

?>

<h2>Editar alunos novos</h2>

<?php

echo $this->Form->create('Alunonovo', array('action'=>'edit'));
echo $this->Form->input('registro');
echo $this->Form->input('nome');
echo $this->Form->input('nascimento', array('label'=>'Data de nascimento', 'dateFormat'=>'DMY', 'minYear'=>'1910', 'empty'=>TRUE));
echo $this->Form->input('cpf');
echo $this->Form->input('identidade');
echo $this->Form->input('orgao');
echo $this->Form->input('email');
echo $this->Form->input('codigo_telefone', array('default'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_celular', array('default'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('endereco');
echo $this->Form->input('cep');
echo $this->Form->input('bairro');
echo $this->Form->input('municipio', array('default'=>'Rio de Janeiro'));
echo $this->Form->input('id', array('type'=>'hidden'));
echo $this->Form->end('Atualizar');

?>