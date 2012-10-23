<table>
    <tbody>
        <tr>
            <td>Instituição</td>
            <td><?php echo $mural[0]['Mural']['instituicao']; ?></td>
        </tr>
        <tr>
            <td>Vagas</td>
            <td><?php echo $mural[0]['Mural']['vagas']; ?></td>
        </tr>
        <tr>
            <td>Benefícios</td>
            <td><?php echo $mural[0]['Mural']['beneficios']; ?></td>
        </tr>
        <tr>
            <td>Final de semana</td>
            <td>
            <?php 
			switch ($mural[0]['Mural']['final_de_semana']) {
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
            <td><?php echo $mural[0]['Mural']['cargaHoraria']; ?></td>
        </tr>
        <tr>
            <td>Requisitos</td>
            <td><?php echo $mural[0]['Mural']['requisitos']; ?></td>
        </tr>
        <tr>
            <td>Área</td>
            <td><?php echo $mural[0]['Area']['area']; ?></td>
        </tr>
        <tr>
            <td>Professor</td>
            <td><?php echo $mural[0]['Professor']['nome']; ?></td>
        </tr>       
        <tr>
            <td>Horário</td>
            <td>
            <?php 
            switch ($mural[0]['Mural']['horario']) {
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
            <td><?php echo date('d-m-Y', strtotime($mural[0]['Mural']['dataInscricao'])); ?></td>
        </tr>
        <tr>
            <td>Data da seleção</td>
            <td><?php echo date('d-m-Y', strtotime($mural[0]['Mural']['dataSelecao'])) . " Horário: " . $mural[0]['Mural']['horarioSelecao']; ?></td>
        </tr>
        <tr>
            <td>Local da seleção</td>
            <td><?php echo $mural[0]['Mural']['localSelecao']; ?></td>
        </tr>

        <tr>
            <td>Forma de seleção</td>
            <td>
            <?php
            switch ($mural[0]['Mural']['formaSelecao']) {
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
            <td><?php echo $mural[0]['Mural']['contato']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $mural[0]['Mural']['email']; ?></td>
        </tr>
        <tr>
            <td>Observações</td>
            <td><?php echo $mural[0]['Mural']['outras']; ?></td>
        </tr>
    </tbody>
</table>

<p>Inscrições: <a href='http://www.ess.ufrj.br/estagio'>http://www.ess.ufrj.br/estagio</a></p>
