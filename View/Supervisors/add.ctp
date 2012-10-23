<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->script("jquery.maskedinput", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    $("#SupervisorCpf").mask("999999999-99");
    $("#SupervisorTelefone").mask("9999.9999");
    $("#SupervisorCelular").mask("9999.9999");
    $("#SupervisorCep").mask("99999-999");

});

', array('inline'=>false));

?>

<?php

echo $this->Form->create('Supervisor');
echo $this->Form->input('regiao', array('default'=>7));
echo $this->Form->input('cress');
echo $this->Form->input('nome');
echo $this->Form->input('cpf');
echo $this->Form->input('codigo_tel', array('default'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_cel', array('default'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('email');
echo $this->Form->input('endereco');
echo $this->Form->input('cep');
echo $this->Form->input('bairro');
echo $this->Form->input('municipio');
echo $this->Form->input('escola');
echo $this->Form->input('ano_formatura');
echo $this->Form->input('outros_estudos');
echo $this->Form->input('area_curso');
echo $this->Form->input('ano_curso');
echo $this->Form->input('observacoes', array('textarea', array('rows'=>5, 'cols'=>60)));
echo $this->Form->input('Instituicao.id', array('label'=>'Instituição', 'options'=>$instituicoes, 'default'=>0));
echo $this->Form->end('Confirma');

?>