<?php

echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

    $(document).ready(function() {
        $("#UserestagioCategoria").change(function() {

            var categoria = $(this).val();

            if (categoria == 2) {
                $("label:eq(1)").text("DRE");
                } else if (categoria == 3) {
                $("label:eq(1)").text("SIAPE");
                } else if (categoria == 4) {
                $("label:eq(1)").text("CRESS 7ª Região");
            }

        })
    })

    ', array("inline"=>false)

);

?>

<h1>Cadastro de usuário</h1>

<?php echo $this->Form->create("Userestagio"); ?>

<table>

    <tr>
        <td>
            <?php echo $this->Form->input('categoria', array('options'=>array('9'=>'- Selecione -', '2'=>'Estudante', '3'=>'Professor', '4'=>'Supervisor'), 'default'=>'9')); ?>
        </td>
        <td>
            <?php echo $this->Form->input('numero', array('label'=>'Selecione a categoria de usuário no box anterior')); ?>
        </td>
    </tr>

    <tr>
        <td colspan='2'>
            <?php echo $this->Form->input('email'); ?>
        </td>
    </tr>

    <tr>
        <td colspan='2'>
            <?php echo $this->Form->input('password', array('label' => 'Senha')); ?>
        </td>
    </tr>
<!--
    <td colspan='2'>
        <?php echo $this->Form->input('Confirmar a senha', array('type' => 'password')); ?>
    </td>
-->
</tr>

</table>

<?php echo $this->Form->end('Confirma?'); ?>
