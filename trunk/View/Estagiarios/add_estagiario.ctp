<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->script("jquery.maskedinput", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    $("#EstagiarioRegistro").mask("999999999");

});

', array('inline'=>false));

?>

<?php

echo $this->Form->create('Estagiario');
echo $this->Form->input('registro');
echo $this->Form->end('Confirma');

?>
