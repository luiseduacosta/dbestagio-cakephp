<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->scriptBlock('

$(document).ready(function() {
$("#UserNumero").hide();
$("#UserCategoria").change(function() {

        $("#UserNumero").show();

	var categoria = $(this).val();

	if (categoria == 1) {
		$("label:eq(1)").text("DRE");
	} else if (categoria == 2) {
		$("label:eq(1)").text("SIAPE");
	} else if (categoria == 3) {
		$("label:eq(1)").text("CRESS 7ª Região");
	} else {
            $("#UserNumero").hide();
            $("label:eq(1)").text("Selecione uma categoria de usuário");
        }

	})
})

', array("inline"=>false));
 ?>

<h1>Cadastro de usuário</h1>

<?php echo $form->create("User"); ?>

<table>

<tr>
	<td>
		<?php echo $form->input('categoria', array('options'=>array('9'=>'- Selecione -', '1'=>'Estudante', '2'=>'Professor', '3'=>'Supervisor'), 'default'=>'9')); ?>
	</td>
	<td>
		<?php echo $form->input('numero', array('label'=>'Selecione a categoria de usuário')); ?>
	</td>
</tr>

<tr>
	<td colspan='2'>
		<?php echo $form->input('email'); ?>
	</td>
</tr>

<tr>
	<td colspan='2'>
	<?php echo $form->input('password'); ?>
	</td>
</tr>

<tr>
    <td colspan='2'>
    	<?php echo $form->input('password_confirm', array('type' => 'password')); ?>
     </td>
</tr>

</table>

<?php echo $form->end('Confirma?'); ?>
