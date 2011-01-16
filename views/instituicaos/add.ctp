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
echo $form->input('url', array('label'=>'Endereço na internet (inclua o protocolo: http://)'));
echo $form->input('convenio', array('label'=>'Número de convênio na UFRJ', 'default'=>0));
echo $form->input('seguro', array('options'=>array('0'=>'Não', '1'=>'Sim')));
echo $form->input('area');
echo $form->input('natureza');
echo $form->input('endereco');
echo $form->input('cep');
echo $form->input('bairro');
echo $form->input('municipio');
echo $form->input('telefone');
echo $form->input('fax');
echo $form->input('beneficio');
echo $form->input('final_de_semana', array('options'=>array('0'=>'Não', '1'=>'Sim', '2'=>'Parcialmente'), 'default'=>0));
echo $form->input('observacoes', array('type'=>'textarea', array('rows'=>5, 'cols'=>60)));
echo $form->end('Confirmar');

?>