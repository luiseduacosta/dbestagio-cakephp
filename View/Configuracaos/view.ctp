<?php echo $this->Html->link('Configurações','/configuracaos/view/1'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Usuários','/aros/listausuarios/'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Permissões','/aros/indexaros/'); ?>

<h1>Configuração</h1>

<table>

<tr>
<td>
Período atual do mural
</td>
<td>
<?php echo $configuracao['Configuracao']['mural_periodo_atual']; ?>
</td>
</tr>

<tr>
<td>
Turma atual do curso de supervisores
</td>
<td>
<?php echo $configuracao['Configuracao']['curso_turma_atual']; ?>
</td>
</tr>

<tr>
<td>
Data de encerramento das inscrições para o curso de supervisores
</td>
<td>
<?php echo date('d-m-Y', strtotime($configuracao['Configuracao']['curso_encerramento_inscricoes'])); ?>
</td>
</tr>

<tr>
<td>
Período do termo de compromisso
</td>
<td>
<?php echo $configuracao['Configuracao']['termo_compromisso_periodo']; ?>
</td>
</tr>

<tr>
<td>
Data de início do termo de compromisso
</td>
<td>
<?php echo date('d-m-Y', strtotime($configuracao['Configuracao']['termo_compromisso_inicio'])); ?>
</td>
</tr>

<tr>
<td>
Data de finalização do termo de compromisso
</td>
<td>
<?php echo date('d-m-Y', strtotime($configuracao['Configuracao']['termo_compromisso_final'])); ?>
</td>
</tr>

</table>

<?php
echo $this->Html->link('Editar','/Configuracaos/edit/'. $configuracao['Configuracao']['id']);
?>