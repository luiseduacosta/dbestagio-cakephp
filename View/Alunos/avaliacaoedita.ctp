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

<h1>Preencha todos os campos do formulário</h1>

<p>
Estudante: <?php echo $aluno; ?><br />
Registro: <?php echo $registro; ?><br />
Período: <?php echo $periodo; ?><br />
Nível: <?php echo $nivel; ?><br />
Professor: <?php echo $professor; ?><br />
Instituição: <?php echo $instituicao; ?><br />
Supervisor: <?php echo $supervisor; ?> <br />
</p>

<?php
echo $this->Form->create('Supervisor');
echo $this->Form->input('regiao', array('default'=>7));
echo $this->Form->input('cress');
echo $this->Form->input('nome');
?>

<?php
echo $this->Form->input('codigo_tel', array('default'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_cel', array('default'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('email');
?>

<?php
echo $this->Form->end('Confirma');
?>