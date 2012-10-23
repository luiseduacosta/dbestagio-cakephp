<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->script("jquery.maskedinput", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    $("#InstituicaoCep").mask("99999-999");
    $("#InstituicaoCnpj").mask("99.999.999/9999-99");
});

', array('inline'=>false));


?>

<?php

echo $this->Form->create('Instituicao');
echo $this->Form->input('instituicao');
echo $this->Form->input('cnpj');
echo $this->Form->input('email');
echo $this->Form->input('url', array('label'=>'Endereço na internet (inclua o protocolo: http://)'));
echo $this->Form->input('convenio', array('label'=>'Número de convênio na UFRJ', 'default'=>0));
echo $this->Form->input('seguro', array('options'=>array('0'=>'Não', '1'=>'Sim')));
echo $this->Form->input('area_instituicoes_id', array('options'=>$area_instituicao, 'empty'=>true));
echo $this->Form->input('natureza');
echo $this->Form->input('endereco');
echo $this->Form->input('cep');
echo $this->Form->input('bairro');
echo $this->Form->input('municipio');
echo $this->Form->input('telefone');
echo $this->Form->input('fax');
echo $this->Form->input('beneficio');
echo $this->Form->input('final_de_semana', array('options'=>array('0'=>'Não', '1'=>'Sim', '2'=>'Parcialmente'), 'default'=>0));
echo $this->Form->input('observacoes', array('type'=>'textarea', array('rows'=>5, 'cols'=>60)));
echo $this->Form->end('Confirmar');

?>