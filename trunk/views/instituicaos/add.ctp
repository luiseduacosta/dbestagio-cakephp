<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#InstituicaoCep").mask("99999-999");

});

', array('inline'=>false));

?>

<h1>Cadastro de instituições</h1>

<?php

echo $form->create('Instituicao');
echo $form->input('instituicao');
echo $form->input('endereco');
echo $form->input('cep');
echo $form->input('bairro');
echo $form->input('municipio');
echo $form->input('observacoes');
echo $form->end('Confirmar');

?>