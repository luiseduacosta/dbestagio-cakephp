<?php

// pr($mural);

echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;

var base_url = window.location.pathname.split("/");

$("#MuralPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        if (url === "localhost") {
        window.location="/" + base_url[1] + "/murals/index/periodo:"+periodo;
        } else {
        window.location="/murals/index/periodo:"+periodo;
        }
	})

})

', array("inline" => false)
);
?>

<br>
<?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria') === 'supervisor')): ?>
    <?php echo $this->Html->link('Inserir mural', '/Murals/add/'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Listar alunos', '/Inscricaos/index/'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Alunos sem inscrição', '/Inscricaos/orfao/'); ?>
    <?php echo " | "; ?>
<?php endif; ?>

<div align="center">

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Mural', array('url' => 'index')); ?>
        <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Mural de estágios da ESS/UFRJ', 'style' => 'display: inline'), 'options' => $todos_periodos, 'default' => $periodo)); ?>
        <?php echo $this->Form->end(); ?>
    <?php else: ?>
        <?php echo $this->Html->link('Termo de compromisso', '/users/login'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Avaliação discente', '/users/login'); ?>
        <h1>Mural de estágios da ESS/UFRJ. Período: <?php echo $periodo; ?></h1>
    <?php endif; ?>

</div>
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
            <th>Atual</th>            
            <th>Inscritos</th>
            <th style="width: 25%">Benefícios</th>
            <th>Encerramento</th>
            <th>Seleção</th>
            <th>Email enviado</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($mural as $data): ?>
    <?php if ($data['Mural']['localInscricao'] == '1'): ?>
                <tr style="background-color:yellow">
            <?php else: ?>
                <tr>    
                <?php endif; ?>    
                <td><?php echo $this->Html->link($data['Mural']['id'], '/Murals/view/' . $data['Mural']['id']); ?></td>
                <td><?php echo $this->Html->link($data['Mural']['instituicao'], '/Murals/view/' . $data['Mural']['id']); ?></td>
                <td style="text-align: center"><?php echo $data['Mural']['vagas']; ?></td>
    <?php if ($this->Session->read('id_categoria') === '1' || $this->Session->read('id_categoria') === '3' || $this->Session->read('id_categoria') === '4'): ?>
                    <td style="text-align: center"><?php echo $this->Html->link($data['Mural']['estagiarios'], '/Estagiarios/index/instituicao_id:' . $data['Mural']['id_estagio'] . '/periodo:' . $data['Mural']['periodo']); ?></td>
                    <td style="text-align: center"><?php echo $this->Html->link($data['Mural']['inscricoes'], '/Inscricaos/index/' . $data['Mural']['id']); ?></td>
                <?php else: ?>
                    <td style="text-align: center"><?php echo $data['Mural']['estagiarios']; ?></td>
                    <td style="text-align: center"><?php echo $data['Mural']['inscricoes']; ?></td>
                <?php endif; ?>

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
        echo date('d-m-Y', strtotime($data['Mural']['dataSelecao'])) . " Horário: " . $data['Mural']['horarioSelecao'];
    }
    ?>
                </td>

                <td>
    <?php
    if (empty($data['Mural']['datafax'])) {
        echo "Sem data";
    } else {
        echo date('d-m-Y', strtotime($data['Mural']['datafax']));
    }
    ?>
                </td>
            </tr>
                <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td style="text-align: center">Total: </td>
            <td style="text-align: center"><?php echo $total_vagas; ?></td>
            <td style="text-align: center"><?php echo $total_estagiarios; ?></td>
        </tr>
    </tfoot>
</table>
