<?php 

echo $html->link('Excluir instituição','/Murals/delete/' . $mural['Mural']['id'], NULL, 'Tem certeza?');
echo " | ";
echo $html->link('Editar instituição','/Murals/edit/' . $mural['Mural']['id']);
echo " | ";
echo $html->link('Listar mural','/Murals/index/');
echo " | ";
echo $html->link('Listar inscritos','/Inscricaos/index/' . $mural['Mural']['id']);

echo "<br />";

echo $html->link('Imprimir cartaz','/Murals/publicacartaz/' . $mural['Mural']['id']);
echo " | ";
echo $html->link('Publicar no Google','/Murals/publicagoogle/' . $mural['Mural']['id']);
echo " | ";
echo $html->link('Enviar inscrições por email','/Inscricaos/emailparainstituicao/' . $mural['Mural']['id']);

?>

<table>
    <thead>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Instituição</td>
            <td><?php echo $mural['Mural']['instituicao']; ?></td>
        </tr>

        <tr>
            <td>Convênio</td>
            <td>
                <?php
                switch ($mural['Mural']['convenio']) {
                    case 0: $convenio = 'Não'; break;
                    case 1: $convenio = 'Sim'; break;
                    }
                echo $convenio;
                ?>
            </td>
        </tr>

        <tr>
            <td>Período</td>
            <td><?php echo $mural['Mural']['periodo']; ?></td>
        </tr>

        <tr>
            <td>Vagas</td>
            <td><?php echo $mural['Mural']['vagas']; ?></td>
        </tr>

        <tr>
            <td>Benefícios</td>
            <td><?php echo $mural['Mural']['beneficios']; ?></td>
        </tr>

        <tr>
            <td>Final de semana</td>
            <td>
            <?php 
			switch ($mural['Mural']['final_de_semana']) {
				case 0: $final_de_semana = 'Não'; break;
				case 1: $final_de_semana = 'Sim'; break;
				case 2: $final_de_semana = 'Parcialmente'; break;	
			}
			echo $final_de_semana; 
			?>
			</td>
        </tr>

        <tr>
            <td>Carga horária</td>
            <td><?php echo $mural['Mural']['cargaHoraria']; ?></td>
        </tr>

        <tr>
            <td>Requisitos</td>
            <td><?php echo $mural['Mural']['requisitos']; ?></td>
        </tr>

        <tr>
            <td>Área de OTP</td>
            <td><?php echo $mural['Area']['area']; ?></td>
        </tr>

        <tr>
            <td>Professor</td>
            <td><?php echo $mural['Professor']['nome']; ?></td>
        </tr>       

        <tr>
            <td>Horário</td>
            <td>
            <?php 
            switch ($mural['Mural']['horario']) {
				case 'D': $horario = 'Diurno'; break;
				case 'N': $horario = 'Noturno'; break;
				case 'A': $horario = 'Ambos'; break;
			}
            echo $horario; 
			?>
			</td>
        </tr>

        <tr>
            <td>Inscrições até o dia: </td>
            <td><?php echo date('d-m-Y', strtotime($mural['Mural']['dataInscricao'])); ?></td>
        </tr>

        <tr>
            <td>Data da seleção</td>
            <td><?php echo date('d-m-Y', strtotime($mural['Mural']['dataSelecao'])) . " Horário: " . $mural['Mural']['horarioSelecao']; ?></td>
        </tr>

        <tr>
            <td>Local da seleção</td>
            <td><?php echo $mural['Mural']['localSelecao']; ?></td>
        </tr>

        <tr>
            <td>Forma de seleção</td>
            <td>
            <?php
            switch ($mural['Mural']['formaSelecao']) {
				case 0: $formaselecao = 'Entrevista'; break;
				case 1: $formaselecao = 'CR'; break;
				case 2: $formaselecao = 'Prova'; break;
				case 3: $formaselecao = 'Outra'; break; 
			}
			echo $formaselecao; 
            ?>
            </td>
        </tr>

        <tr>
            <td>Contatos</td>
            <td><?php echo $mural['Mural']['contato']; ?></td>
        </tr>

        <tr>
            <td>Email</td>
            <td><?php echo $mural['Mural']['email']; ?>
            </td>
        </tr>

        <tr>
            <td>Email enviado</td>
            <td><?php
                if ($mural['Mural']['datafax']) {
                    echo date('d-m-Y', strtotime($mural['Mural']['datafax']));
                } else {
                    echo "Email não enviado";
                }
                ?>
            </td>
        </tr>

        <tr>
            <td>Data de envio do email</td>
            <td><?php echo $mural['Mural']['datafax']; ?></td>
        </tr>

        <tr>
            <td>Observações</td>
            <td><?php echo $mural['Mural']['outras']; ?></td>
        </tr>

        <tr>
            <td colspan = 2>
            <?php echo $form->create('Inscricao', array('action'=>'add/' . $mural['Mural']['id'])); ?>
            <?php echo $form->input('id_instituicao', array('type'=>'hidden', 'value'=>$mural['Mural']['id'])); ?>
            <?php echo $form->end('Inscrição'); ?>
            </td>
        </tr>

    </tbody>
</table>