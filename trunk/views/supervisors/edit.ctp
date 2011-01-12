<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?php

echo $form->create('Supervisor');
echo $form->input('cress');
echo $form->input('nome');
echo $form->input('cpf');
echo $form->input('codigo_tel', array('default'=>21));
echo $form->input('telefone');
echo $form->input('codigo_cel', array('default'=>21));
echo $form->input('celular');
echo $form->input('email');
echo $form->input('endereco');
echo $form->input('cep');
echo $form->input('bairro');
echo $form->input('municipio');
echo $form->end('Confirma');

?>