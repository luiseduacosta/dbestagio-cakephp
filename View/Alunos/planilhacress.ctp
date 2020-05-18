<?php
// pr($cress);
// pr($periodos);
// pr($periodoatual);
?>

<?php
echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;

var base_url = window.location.pathname.split("/");

$("#AlunoPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/alunos/planilhacress/periodo:"+periodo;
        } else {
            window.location="/alunos/planilhacress/periodo:"+periodo;
        }
})
});

', array("inline" => false));
?>

<div id="estagiario_seleciona" style="align-content: center;">
    <table  style="width:95%; border:0px;">
        <tr>
            <td>
                <?php echo $this->Form->create('Aluno', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos, 'selected' => $periodoatual, 'empty' => array($periodoatual => 'Período'))); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
            <td>
        </tr>
    </table>
</div>

<table>
    <caption>Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª Região</caption>
    <tr>
        <th>Estudante</th>
        <th>Instituição</th>
        <th>Endereço</th>
        <th>CEP</th>
        <th>Bairro</th>
        <th>Supervisor</th>
        <th>CRESS</th>
        <th>Professor</th>
    </tr>
<?php foreach ($cress as $c_cress): ?>
    <?php // pr($c_cress); ?>
        <tr>
            <td><?php echo $this->Html->link($c_cress['Aluno']['nome'], '/Alunos/view/' . $c_cress['Aluno']['id']); ?></td>
            <td><?php echo $this->Html->link($c_cress['Instituicao']['instituicao'], '/Instituicoes/view/' . $c_cress['Instituicao']['id']); ?></td>
            <td><?php echo $c_cress['Instituicao']['endereco']; ?></td>
            <td><?php echo $c_cress['Instituicao']['cep']; ?></td>
            <td><?php echo $c_cress['Instituicao']['bairro']; ?></td>
            <td><?php echo $c_cress['Supervisor']['nome']; ?></td>
            <td><?php echo $c_cress['Supervisor']['cress']; ?></td>
            <td><?php echo $c_cress['Professor']['nome']; ?></td>
        </tr>
<?php endforeach; ?>
</table>
