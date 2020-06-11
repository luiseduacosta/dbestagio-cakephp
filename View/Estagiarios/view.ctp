<?php echo $this->Html->link('Estagiarios', '/Estagiarios/index/' . $estagio['Estagiario']['periodo']); ?>

<h1>Estágiario: <?php echo $estagio['Aluno']['nome']; ?></h1>
<table>
    <tbody>

        <tr>
            <td><?php echo 'Id: ' . $estagio['Estagiario']['aluno_id']; ?></td>
            <td><?php echo $estagio['Estagiario']['registro']; ?></td>
        </tr>

        <tr>
            <td>Período</td>
            <td><?php echo $estagio['Estagiario']['periodo']; ?></td>
        </tr>

        <tr>
            <td>Nível</td>
            <td><?php echo $estagio['Estagiario']['nivel']; ?></td>
        </tr>

        <tr>
            <td>Turno</td>
            <td>
            <?php 
            switch ($estagio['Estagiario']['turno']) {
				case 'D': echo 'Diurno'; break;
				case 'N': echo 'Noturno'; break;
				case 'I': echo 'Indeterminado'; break;
			}
			?>
            </td>
        </tr>

        <tr>
            <td>Solicitação do TC</td>
            <td><?php echo date('d-m-Y', strtotime($estagio['Estagiario']['tc_solicitacao'])); ?></td>
        </tr>

        <tr>
            <td>TC (Devolução do TC)</td>
            <td>
            <?php
            switch ($estagio['Estagiario']['tc']) {
				case 0: echo "Não"; break;
				case 1: echo "Sim"; break;
			} 
			?>
            </td>
        </tr>

        <tr>
            <td>Professor</td>
            <td><?php echo $estagio['Professor']['nome']; ?></td>
        </tr>

        <tr>
            <td>Área temática</td>
            <td><?php echo $estagio['Areaestagio']['area']; ?></td>
        </tr>

        <tr>
            <td>Instituição</td>
            <td><?php echo $estagio['Instituicao']['instituicao']; ?></td>
        </tr>

        <tr>
            <td>Supervisor</td>
            <td><?php echo $estagio['Supervisor']['nome']; ?></td>
        </tr>

        <tr>
            <td>Nota</td>
            <td><?php echo $estagio['Estagiario']['nota']; ?></td>
        </tr>

        <tr>
            <td>Carga horária</td>
            <td><?php echo $estagio['Estagiario']['ch']; ?></td>
        </tr>

        <tr>
            <td>Observações</td>
            <td><?php echo $estagio['Estagiario']['observacoes']; ?></td>
        </tr>

    </tbody>
</table>

<p>

<?php echo $this->Html->link('Editar', '/Estagiarios/edit/' . $estagio['Estagiario']['id']); ?> |
<?php echo $this->Html->link('Inserir estágio', '/Estagiarios/add/' . $estagio['Estagiario']['aluno_id']); ?> | 
<?php echo $this->Html->link('Listar', '/Estagiarios/index/' . $estagio['Estagiario']['periodo']); ?>

</p>