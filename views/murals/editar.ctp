<?php

if (empty($instituicoes)) $instituicoes = "Sem dados";
if (empty($areas)) $areas = "Sem dados";
if (empty($professores)) $professores = "Sem dados";

?>

<?php echo $form->create('Mural'); ?>

<table>
    <thead>
        <tr>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr>
             <td>
                 <?php
                 echo $form->input('id_estagio', array('label'=>'Instituição', 'type'=>'select', 'options'=>$instituicoes));
                 ?>
             </td>
        </tr>

        <tr>
             <td>
                 <?php
                 echo $form->input('convenio', array('label'=>'Convênio', 'type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim')));
                 ?>
             </td>
        </tr>

        <tr>
             <td>
            <?php echo $form->input('periodo', array('type'=>'text')); ?>
             </td>
        </tr>

        <tr>
            <td><?php echo $form->input('vagas', array('label'=>'Vagas (digitar somente números inteiros)')); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('beneficios'); ?></td>
        </tr>

        <tr>
            <td>
            <?php
            echo $form->input('final_de_semana', array('type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim', '2'=>'Parcialmente'))); 
            ?>
            </td>
        </tr>

        <tr>
            <td><?php echo $form->input('cargaHoraria'); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('requisitos', array('rows'=>4)); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('id_area', array('label'=>'Área de OTP', 'type'=>'select', 'options'=>$areas)); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('horario', array('type'=>'select', 'options'=>array('D'=>'Diurno', 'N'=>'Noturno', 'A'=>'Ambos'))); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('id_professor', array('label'=>'Professor', 'type'=>'select', 'options'=>array($professores))); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('dataInscricao', array('dateFormat'=>'DMY', 'empty'=>TRUE)); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('dataSelecao', array('dateFormat'=>'DMY', 'empty'=>TRUE)); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('horarioSelecao'); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('localSelecao'); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('formaSelecao', array('type'=>'select', 'options'=>array('0'=>'Entrevista', '1'=>'CR', '2'=>'Prova', '3'=>'Outra'))); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('contato'); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('email'); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('datafax', array('label'=>'Data de envio do email', 'empty'=>TRUE)); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->input('outras'); ?></td>
        </tr>

    </tbody>
</table>

<?php echo $form->end("Confirma"); ?>