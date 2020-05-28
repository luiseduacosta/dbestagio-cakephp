<?php

echo $this->Html->script("jquery.maskedinput-1.3.1", array('inline'=>false));

echo $this->Html->scriptBlock('

$(document).ready(function(){

    $("#EstudanteCpf").mask("999999999-99");
    $("#EstudanteTelefone").mask("9999.9999");
    $("#EstudanteCelular").mask("99999.9999");
    $("#EstudanteCep").mask("99999-999");

});

', array('inline'=>false));

?>

<?php echo $this->Form->create('Estudante'); ?>

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
                <label for="EstudanteRegistro">Registro na UFRJ (DRE): <?php echo $this->Session->read('numero'); ?></label>
                <?php echo $this->Form->input('registro', array('type'=>'hidden', 'value'=>$registro, 'default'=>$this->Session->read('numero'))); ?>
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
                <?php $regisro = isset($registro) ? $registro : null; ?>
                <?php echo $this->Form->input('registro', array('type'=>'text', 'value'=> $registro, 'default' => $this->Session->read('numero'))); ?>
            </td>
            </tr>
            <?php endif; ?>
        <?php endif; ?>

        <tr>
        <td colspan="2">
            <?php echo $this->Form->input('nome'); ?>
        </td>
        </tr>

        <tr>
            <td colspan="2">
            <?php echo $this->Form->input('nascimento', array('label'=>'Data de nascimento', 'dateFormat'=>'DMY', 'minYear'=>'1910', 'empty'=>TRUE)); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
            <?php echo $this->Form->input('cpf'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $this->Form->input('identidade'); ?>
            </td>
            <td>
            <?php echo $this->Form->input('orgao'); ?>
            </td>
        </tr>

        <?php if ($this->Session->read('numero') || ($this->Session->read('categoria') === 'estudante')): ?>
        <tr>
            <td colspan="2">
            <label for="EstudanteEmail">Email: <?php echo strtolower($this->Session->read('user')); ?></label>
            <?php echo $this->Form->input('email', array('type'=>'hidden', 'default'=>$this->Session->read('user'))); ?>
            </td>
        </tr>
        <?php else: ?>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <tr>
                <td colspan="2">
                <?php echo $this->Form->input('email'); ?>
                </td>
            </tr>
            <?php endif; ?>
        <?php endif; ?>

        <tr>
            <td>
            <?php echo $this->Form->input('codigo_tel', array('default'=>21)); ?>
            </td>
            <td>
            <?php echo $this->Form->input('telefone'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $this->Form->input('codigo_cel', array('default'=>21)); ?>
            </td>
            <td>
            <?php echo $this->Form->input('celular'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $this->Form->input('endereco'); ?>
            </td>
            <td>
            <?php echo $this->Form->input('cep'); ?>
            </td>
        </tr>

        <tr>
            <td>
            <?php echo $this->Form->input('bairro'); ?>
            </td>
            <td>
            <?php echo $this->Form->input('municipio', array('default'=>'Rio de Janeiro, RJ')); ?>
            </td>
        </tr>

    </table>
</fieldset>

<?php
if (isset($instituicao_id)) {
    echo $this->Form->input('instituicao_id', array('type'=>'hidden', 'value'=>$instituicao_id));
} else {
    echo $this->Form->input('instituicao_id', array('type'=>'hidden'));
}
?>

<span style="text-align: center">
<?php echo $this->Form->end('Confirma'); ?>
</span>
