<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#AlunoRegistro").mask("999999999");
    $("#AlunoCpf").mask("999999999-99");
    $("#AlunoTelefone").mask("9999.9999");
    $("#AlunoCelular").mask("9999.9999");
    $("#AlunoCep").mask("99999-999");

});

', array('inline'=>false));

?>

<?php echo $html->link('Listar','/Alunos/index/'); ?>

<?php

/*
 * O cadastro do aluno pode receber a informacao da tabela alunonovo
 */

if (!isset($alunonovo['Alunonovo']['nome'])) $alunonovo['Alunonovo']['nome'] = NULL;
if (!isset($alunonovo['Alunonovo']['registro'])) $alunonovo['Alunonovo']['registro'] = NULL;
if (!isset($registro)) $registro = NULL;
if (!isset($alunonovo['Alunonovo']['nascimento'])) $alunonovo['Alunonovo']['nascimento'] = NULL;
if (!isset($alunonovo['Alunonovo']['cpf'])) $alunonovo['Alunonovo']['cpf'] = NULL;
if (!isset($alunonovo['Alunonovo']['identidade'])) $alunonovo['Alunonovo']['identidade'] = NULL;
if (!isset($alunonovo['Alunonovo']['orgao'])) $alunonovo['Alunonovo']['orgao'] = NULL;
if (!isset($alunonovo['Alunonovo']['email'])) $alunonovo['Alunonovo']['email'] = NULL;
if (!isset($alunonovo['Alunonovo']['codigo_telefone'])) $alunonovo['Alunonovo']['codigo_telefone'] = 21;
if (!isset($alunonovo['Alunonovo']['telefone'])) $alunonovo['Alunonovo']['telefone'] = NULL;
if (!isset($alunonovo['Alunonovo']['codigo_celular'])) $alunonovo['Alunonovo']['codigo_celular'] = NULL;
if (!isset($alunonovo['Alunonovo']['celular'])) $alunonovo['Alunonovo']['celular'] = NULL;
if (!isset($alunonovo['Alunonovo']['endereco'])) $alunonovo['Alunonovo']['endereco'] = NULL;
if (!isset($alunonovo['Alunonovo']['bairro'])) $alunonovo['Alunonovo']['bairro'] = NULL;
if (!isset($alunonovo['Alunonovo']['municipio'])) $alunonovo['Alunonovo']['municipio'] = NULL;
if (!isset($alunonovo['Alunonovo']['cep'])) $alunonovo['Alunonovo']['cep'] = NULL;

?>

<h1>Inserir aluno</h1>

<?php
echo $form->create('Aluno', array('action'=>'add'));
?>

<fieldset>
    <legend>Dados do aluno</legend>
    <table border="1">

        <tr>
        <td colspan="2">
            <?php echo $form->input('nome', array('value'=>$alunonovo['Alunonovo']['nome'])); ?>
        </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $form->input('registro', array('value'=>$registro, 'size'=>'9','maxLenght'=>'9')); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $form->input('nascimento', array('label'=>'Data de nascimento', 'value'=>$alunonovo['Alunonovo']['nascimento'], 'dateFormat'=>'DMY', 'minYear'=>'1910', 'empty'=>TRUE)); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $form->input('cpf', array('value'=>$alunonovo['Alunonovo']['cpf'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $form->input('identidade', array('label'=>'Cartera de identidade', 'value'=>$alunonovo['Alunonovo']['identidade'])); ?>
            </td>
            <td>
                <?php echo $form->input('orgao', array('label'=>'Orgão', 'legend'=>false, 'value'=>$alunonovo['Alunonovo']['orgao'])); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $form->input('email', array('value'=>$alunonovo['Alunonovo']['email'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $form->input('codigo_telefone', array('default'=>21, 'value'=>$alunonovo['Alunonovo']['codigo_telefone'])); ?>
            </td>
            <td>
                <?php echo $form->input('telefone', array('value'=>$alunonovo['Alunonovo']['telefone'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $form->input('codigo_celular', array('default'=>21, 'value'=>$alunonovo['Alunonovo']['codigo_celular'])); ?>
            </td>
            <td>
                <?php echo $form->input('celular', array('value'=>$alunonovo['Alunonovo']['celular'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $form->input('endereco', array('label'=>'Endereço', 'value'=>$alunonovo['Alunonovo']['endereco'])); ?>
            </td>
            <td>
                <?php echo $form->input('cep', array('value'=>$alunonovo['Alunonovo']['cep'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $form->input('bairro', array('value'=>$alunonovo['Alunonovo']['bairro'])); ?>
            </td>
            <td>
                <?php echo $form->input('municipio', array('value'=>$alunonovo['Alunonovo']['municipio'], 'default'=>'Rio de Janeiro, RJ')); ?>
            </td>
        </tr>

    </table>
</fieldset>

<?php
echo $form->end('Confirma');
?>
