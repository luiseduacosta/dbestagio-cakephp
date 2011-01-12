<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#EstagiarioRegistro").mask("999999999");

});

', array('inline'=>false));

?>

<?php

echo $form->create('Estagiario');
echo $form->input('registro');
echo $form->end('Confirma');

?>
