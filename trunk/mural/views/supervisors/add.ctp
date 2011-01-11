<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#SupervisorCpf").mask("999999999-99");
    $("#SupervisorTelefone").mask("9999.9999");
    $("#SupervisorCelular").mask("9999.9999");
    $("#SupervisorCep").mask("99999-999");

});

', array('inline'=>false));

?>

<?php

echo $form->create('Supervisor');
echo $form->input('cress');
echo $form->input('nome');
echo $form->input('cpf');
echo $form->input('codigo_tel', array('default'=>21));
echo $form->input('telefone');
echo $form->input('codigo_cel', array('default'=>21));
echo $form->input('celular');
echo $form->input('email');
echo $form->input('endereco');
echo $form->input('cep');
echo $form->input('bairro');
echo $form->input('municipio');
echo $form->input('Instituicao.id', array('options'=>$instituicoes, 'default'=>0));
echo $form->end('Confirma');

?>