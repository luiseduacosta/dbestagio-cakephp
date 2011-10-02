<?php echo $html->link('Inserir mural','/Murals/add/'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Listar alunos','/Inscricaos/index/'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Alunos orfãos','/Inscricaos/orfao/'); ?>

<hr />

<h1>Mural de estágios da ESS/UFRJ</h1>
<h2>Período: <?php echo $periodo; ?></h2>
<p>Há <?php echo $total_vagas; ?> vagas de estágio e <?php echo $total_alunos; ?> estudantes buscando estágio (<?php echo $alunos_novos; ?> pela primeira vez e <?php echo $alunos_estagiarios; ?> que mudam de estágio)</p>

<hr />

<?php $totalvagas = NULL; ?>
<?php $totalinscricoes = NULL; ?>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th style="width: 25%">Instituição</th>
            <th>Vagas</th>
            <th>Inscritos</th>
            <th style="width: 25%">Benefícios</th>
            <th>Encerramento</th>
            <th>Seleção</th>
            <th>Email enviado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($mural as $data): ?>
        <tr>
            <td><?php echo $data['Mural']['id']; ?></td>
            <td><?php echo $html->link($data['Mural']['instituicao'], '/Murals/view/' . $data['Mural']['id']); ?></td>
            <td style="text-align: center"><?php echo $data['Mural']['vagas']; ?></td>
            <td style="text-align: center"><?php echo $html->link($data['Mural']['inscricoes'], '/Inscricaos/index/' . $data['Mural']['id']); ?></td>
            <td><?php echo $data['Mural']['beneficios']; ?></td>
            
            <td>
            <?php
            if (empty($data['Mural']['dataInscricao'])) {
			echo "Sem data";
			} else { 
			echo date('d-m-Y', strtotime($data['Mural']['dataInscricao']));
			}
            ?>
            </td>
            
            <td>
            <?php 
            if (empty($data['Mural']['dataSelecao'])) {
			echo "Sem data";
			} else {            
			echo date('d-m-Y', strtotime($data['Mural']['dataSelecao'])). " Horário: " . $data['Mural']['horarioSelecao']; 
			}
			?>
			</td>
			
            <td>
            <?php
            if (empty($data['Mural']['datafax'])) {
			echo "Sem data";
			} else {
			echo date('d-m-Y', strtotime($data['Mural']['datafax'])). " Horário: " . $data['Mural']['horarioSelecao']; 
			}
			?>
			</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td style="text-align: center">Total vagas</td>
            <td style="text-align: center"><?php echo $total_vagas; ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>
