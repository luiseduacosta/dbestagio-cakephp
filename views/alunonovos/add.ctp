<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#AlunonovoRegistro").mask("999999999");
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

        <!--
        Verifico que tenha um número e que seja de um estudante
        //-->
        <?php if ($this->Session->read('numero') || ($this->Session->read('categoria') === 'estudante')): ?>
            <tr>
            <td colspan="2">
                <label for="AlunonovoRegistro">Registro na UFRJ (DRE): <?php echo $this->Session->read('numero'); ?></label>
                <?php echo $form->input('registro', array('type'=>'hidden', 'value'=>$registro, 'default'=>$this->Session->read('numero'))); ?>
            </td>
            </tr>
        <!--
        Senão somente o administrador pode cadastrar um aluno novo
        //-->    
        <?php else: ?>
            <?php echo "Estudante sem número de registro na UFRJ (DRE)? " . $this->Session->read('numero'); ?>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <tr>
            <td colspan="2">
                <?php echo $form->input('registro', array('type'=>'text', 'value'=>$registro, 'default'=>$this->Session->read('numero'))); ?>
            </td>
            </tr>
            <?php endif; ?>
        <?php endif; ?>
        
        <tr>
        <td colspan="2">
            <?php echo $form->input('nome'); ?>
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

        <?php if ($this->Session->read('numero') || ($this->Session->read('categoria') === 'estudante')): ?>
        <tr>
            <td colspan="2">
            <label for="AlunonovoEmail">Email: <?php echo $this->Session->read('user'); ?></label>    
            <?php echo $form->input('email', array('type'=>'hidden', 'default'=>$this->Session->read('user'))); ?>
            </td>
        </tr>
        <?php else: ?>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <tr>
                <td colspan="2">
                <?php echo $form->input('email'); ?>    
                </td>
            </tr>
            <?php endif; ?>
        <?php endif; ?>

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

<span style="text-align: center">
<?php echo $form->end('Confirma'); ?>
</span>
