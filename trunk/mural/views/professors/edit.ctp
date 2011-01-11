<?php

echo $html->script("jquery", array('inline'=>false));
echo $html->script("jquery.maskedinput", array('inline'=>false));

echo $html->scriptBlock('

$(document).ready(function(){

    $("#ProfessorCpf").mask("999999999-99");
    $("#ProfessorTelefone").mask("9999.9999");
    $("#ProfessorCelular").mask("9999.9999");

});

', array('inline'=>false));

?>

<?php

echo $form->create('Professor');
echo $form->input('nome');
echo $form->input('cpf');
echo $form->input('siape');
echo $form->input('datanascimento', array('dateFormat'=>'DMY', 'minYear'=>'1900', 'empty'=>TRUE));
echo $form->input('localnascimento');
echo $form->input('sexo', array('options'=>array('1'=>'Masculino', '2'=>'Feminino')));
echo $form->input('telefone');
echo $form->input('celular');
echo $form->input('email');
echo $form->input('homepage');
echo $form->input('redesocial');
echo $form->input('curriculolattes');
echo $form->input('atualizacaolattes', array('dateFormat'=>'DMY', 'minYear'=>'1990', 'empty'=>TRUE));
echo $form->input('curriculosigma');
echo $form->input('pesquisadordgp');
echo $form->input('formacaoprofissional');
echo $form->input('universidadedegraduacao');
echo $form->input('anoformacao');
echo $form->input('mestradoarea');
echo $form->input('mestradouniversidade');
echo $form->input('mestradoanoconclusao');
echo $form->input('doutoradoarea');
echo $form->input('doutoradouniversidade');
echo $form->input('doutoradoanoconclusao');
echo $form->input('dataingresso', array('dateFormat'=>'DMY', 'minYear'=>'1950', 'empty'=>TRUE));
echo $form->input('formaingresso');
echo $form->input('tipocargo', array('options'=>array('efetivo'=>'Efetivo', 'substituto'=>'Substituto')));
echo $form->input('categoria', array('options'=>array('sem dados'=>'Sem dados', 'auxiliar'=>'Auxiliar', 'assistente'=>'Assistente', 'adjunto'=>'Adjunto', 'associado'=>'Associado', 'titular'=>'Titular', 'outro'=>'Outro'), 'default'=>0));
echo $form->input('regimetrabalho', array('options'=>array('40DE'=>'40DE', '40'=>'40', '20'=>'20')));
echo $form->input('departamento', array('options'=>array('Fundamentos'=>'Fundamentos', 'Metodos e tecnicas'=>'Métodos e técnicas', 'Politica social'=>'Política Social')));
echo $form->input('dataegresso', array('dateFormat'=>'DMY', 'minYear'=>'1900', 'empty'=>TRUE));
echo $form->input('motivoegresso');
echo $form->input('observacoes');
echo $form->end('Confirma');

?>