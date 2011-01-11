<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#AlunoRegistro").mask("999999999");
    $("#AlunoCpf").mask("999999999-99");
    $("#AlunoTelefone").mask("9999.9999");
    $("#AlunoCelular").mask("9999.9999");
    $("#AlunoCep").mask("99999-999");

});

', array('inline'=>false));

?>

<h2>Editar</h2>

<?php

$hoje = date('Y-m-d', strtotime('today'));

echo $form->create('Aluno', array('action'=>'edit'));
echo $form->input('nome');
echo $form->input('registro');
echo $form->input('nascimento', array('label'=>'Data de nascimento', 'dateFormat'=>'DMY', 'minYear'=>'1910', 'empty'=>TRUE));
echo $form->input('cpf');
echo $form->input('identidade');
echo $form->input('orgao');
echo $form->input('email');
echo $form->input('codigo_telefone', array('default'=>21));
echo $form->input('telefone');
echo $form->input('codigo_celular', array('default'=>21));
echo $form->input('celular');
echo $form->input('endereco',array('label'=>'Endereço'));
echo $form->input('cep');
echo $form->input('bairro');
echo $form->input('municipio', array('default'=>'Rio de Janeiro'));
echo $form->input('id', array('type'=>'hidden'));
echo $form->end('Atualizar');

?>