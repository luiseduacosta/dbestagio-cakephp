<?php
echo $this->element('submenu_supervisores');
?>

<?php
echo $this->Html->script('jquery.SimpleMask');
?>

<script>
$(document).ready(function(){

    $("#SupervisorCpf").simpleMask({'mask':['#########-##']});
    $("#SupervisorTelefone").simpleMask({'mask':['####.####']});
    $("#SupervisorCelular").simpleMask({'mask':['#####.####']});
    $("#SupervisorCep").simpleMask({'mask':['#####.####']});

});
</script>

<?php

echo $this->Form->create('Supervisor');
echo $this->Form->input('regiao', ['label' => 'Região', 'default'=>7]);
echo $this->Form->input('cress', ['label' => 'CRESS']);
echo $this->Form->input('nome');
echo $this->Form->input('cpf', ['label' => 'CPF']);
echo $this->Form->input('codigo_tel', array('default'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_cel', array('default'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('email');
echo $this->Form->input('endereco', ['label' => 'Endereço']);
echo $this->Form->input('cep', ['label' => 'CEP']);
echo $this->Form->input('bairro', ['label' => 'Bairro']);
echo $this->Form->input('municipio', ['label' => 'Município']);
echo $this->Form->input('escola', ['label' => 'Escola de formação']);
echo $this->Form->input('ano_formatura', ['label' => 'Ano de formatura']);
echo $this->Form->input('outros_estudos', ['label' => 'Outros estudos']);
echo $this->Form->input('area_curso', ['label' => 'Área curso']);
echo $this->Form->input('ano_curso', ['label' => 'Área do curso']);
echo $this->Form->input('observacoes', ['label' => 'Observações', 'textarea' => ['rows'=>5, 'cols'=>60]]);
echo $this->Form->input('Instituicao.id', ['label'=>'Instituição', 'options'=>$instituicoes, 'default'=>0]);
echo $this->Form->end('Confirma');

?>