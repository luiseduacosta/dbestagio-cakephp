<h1>Editar</h1>

<?php echo $html->link('Listar mural','/Murals/index/'); ?>

<?php 

echo $form->create('Mural');

echo $form->input('instituicao', array('label'=>'Instituição'));

echo $form->input('convenio');

echo $form->input('periodo');

echo $form->input('vagas');

echo $form->input('beneficios');

echo $form->input('final_de_semana');

echo $form->input('cargaHoraria');

echo $form->input('requisitos', array('rows'=>4));

echo $form->input('area');

echo $form->input('horario');

echo $form->input('id_professor');

echo $form->input('dataInscricao', array('empty'=>TRUE));

echo $form->input('dataSelecao', array('empty'=>TRUE));

echo $form->input('horarioSelecao');

echo $form->input('localSelecao');

echo $form->input('formaSelecao');

echo $form->input('contato');

echo $form->input('email');

echo $form->input('datafax', array('empty'=>TRUE));

echo $form->input('outras');

echo $form->end('Confirmar');

?>
