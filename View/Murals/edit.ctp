<?php

if (empty($instituicoes)) $instituicoes = "Sem dados";
if (empty($areas)) $areas = "Sem dados";
if (empty($professores)) $professores = "Sem dados";

?>

<?php echo $this->Form->create('Mural'); ?>

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
                 echo $this->Form->input('id', array('type'=>'hidden'));
                 echo $this->Form->input('id_estagio', array('label'=>'Instituição', 'type'=>'select', 'options'=>$instituicoes));
                 ?>
             </td>
        </tr>

        <tr>
             <td>
                 <?php
                 echo $this->Form->input('convenio', array('label'=>'Convênio', 'type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim')));
                 ?>
             </td>
        </tr>

        <tr>
             <td>
            <?php echo $this->Form->input('periodo', array('type'=>'text')); ?>
             </td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('vagas', array('label'=>'Vagas (digitar somente números inteiros)')); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('beneficios'); ?></td>
        </tr>

        <tr>
            <td>
            <?php
            echo $this->Form->input('final_de_semana', array('type'=>'select', 'options'=>array('0'=>'Não', '1'=>'Sim', '2'=>'Parcialmente'))); 
            ?>
            </td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('cargaHoraria'); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('requisitos', array('rows'=>4)); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('id_area', array('label'=>'Área de OTP', 'type'=>'select', 'options'=>$areas)); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('horario', array('type'=>'select', 'options'=>array('D'=>'Diurno', 'N'=>'Noturno', 'A'=>'Ambos'))); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('docente_id', array('label'=>'Professor', 'type'=>'select', 'options'=>array($professores))); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('dataInscricao', array('dateFormat'=>'DMY', 'empty'=>TRUE)); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('dataSelecao', array('dateFormat'=>'DMY', 'empty'=>TRUE)); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('horarioSelecao'); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('localSelecao'); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('formaSelecao', array('type'=>'select', 'options'=>array('0'=>'Entrevista', '1'=>'CR', '2'=>'Prova', '3'=>'Outra'))); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('contato'); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('email'); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('datafax', array('label'=>'Data de envio do email (preenchimento automático)', 'empty'=>TRUE)); ?></td>
        </tr>

        <tr>
            <td><?php echo $this->Form->input('localInscricao', array('label'=>'Local da inscrição', 'type'=>'select', 'options'=>array("0"=>'Mural da Coordenação de Estágio e Extensão/ESS', "1"=>'Diretamente na Instituição'))); ?></td>
        </tr>
        
        <tr>
            <td><?php echo $this->Form->input('outras'); ?></td>
        </tr>

    </tbody>
</table>

<?php echo $this->Form->end("Confirma"); ?>