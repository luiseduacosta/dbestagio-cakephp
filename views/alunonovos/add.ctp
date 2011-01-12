<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#AlunonovoCpf").mask("999999999-99");
    $("#AlunonovoTelefone").mask("9999.9999");
    $("#AlunonovoCelular").mask("9999.9999");
    $("#AlunonovoCep").mask("99999-999");
    
});

', array('inline'=>false));

?>

<?php echo $form->create('Alunonovo'); ?>

<h1>Cadastro de estudante novo para estágio</h1>

<fieldset>
    <legend>Dados do aluno</legend>
    <table border="1">

        <tr>
        <td colspan="2">
            <?php echo $form->input('nome'); ?>
        </td>
        </tr>

        <tr>
        <td colspan="2">
            <?php echo $form->input('registro', array('type'=>'hidden', 'value'=>$registro)); ?>
        </td>
        </tr>

        <tr>
            <td colspan="2">
            <?php echo $form->input('nascimento', array('label'=>'Data de nascimento', 'dateFormat'=>'DMY', 'minYear'=>'1910', 'empty'=>TRUE)); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
            <?php echo $form->input('cpf'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $form->input('identidade'); ?>
            </td>
            <td>
            <?php echo $form->input('orgao'); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
            <?php echo $form->input('email'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $form->input('codigo_tel', array('default'=>21)); ?>
            </td>
            <td>
            <?php echo $form->input('telefone'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $form->input('codigo_cel', array('default'=>21)); ?>
            </td>
            <td>
            <?php echo $form->input('celular'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $form->input('endereco'); ?>
            </td>
            <td>
            <?php echo $form->input('cep'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $form->input('bairro'); ?>
            </td>
            <td>
            <?php echo $form->input('municipio', array('default'=>'Rio de Janeiro, RJ')); ?>
            </td>
        </tr>

    </table>
</fieldset>

<?php
if (isset($id_instituicao)) {
    echo $form->input('id_instituicao', array('type'=>'hidden', 'value'=>$id_instituicao));
} else {
    echo $form->input('id_instituicao', array('type'=>'hidden'));
}
?>

<?php echo $form->end('Confirma'); ?>
