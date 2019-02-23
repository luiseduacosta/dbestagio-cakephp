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
<table>
    <tr>
        <td>Estudante:</td><td><?php echo $aluno; ?></td>
    </tr>
        <tr>
        <td>Registro:</td><td><?php echo $registro; ?></td>
    </tr>
        <tr>
        <td>Período:</td><td><?php echo $periodo; ?></td>
    </tr>
        <tr>
        <td>Nível:</td><td><?php echo $nivel; ?></td>
    </tr>
        <tr>
        <td>Professor:</td><td><?php echo $professor; ?></td>
    </tr>
        <tr>
        <td>Instituição:</td><td><?php echo $instituicao; ?></td>
    </tr>
        <tr>
        <td>Supervisor:</td><td><?php echo $supervisor; ?></td>
    </tr>
</table>
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
echo $this->Form->input('registro', array('type' => 'hidden', 'value' => $registro));
echo $this->Form->input('supervisor_id', array('type' => 'hidden', 'value' => $supervisor_id));
echo $this->Form->end('Confirma');
?>