<?php
echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;

var base_url = window.location.pathname.split("/");

$("#VisitaEstagioId").change(function() {
	var instituicao_id = $(this).val();
        /* alert(instituicao_id); */
        if (url === "localhost") {
        window.location="/" + base_url[1] + "/visitas/add/instituicao:"+instituicao_id;
        } else {
        window.location="/visitas/add/instituicao:"+instituicao_id;
        }
	})

})

', array("inline" => false)
);
?>

<h1>Informe de visita institucional</h1>

<?php // pr($visitas); ?>

<?php if (!empty(($visitas))): ?>
    <table>
        <tr>
            <th>Id</th>
            <th>Instituição</th>
            <th>Data</th>
            <th>Motivo</th>
            <th>Responsável</th>
            <th>Avaliação</th>
        </tr>
        <?php foreach ($visitas as $c_visita): ?>
            <?php // pr($c_visita); ?>
            <tr>
                <td><?php echo $c_visita['Visita']['id']; ?></td>
                <td><?php echo $c_visita['Instituicao']['instituicao']; ?></td>
                <td><?php echo $this->Html->link(date('d-m-Y', strtotime($c_visita['Visita']['data'])), '/visitas/view/' . $c_visita['Visita']['id']); ?></td>
                <td><?php echo $c_visita['Visita']['motivo']; ?></td>
                <td><?php echo $c_visita['Visita']['responsavel']; ?></td>
                <td><?php echo $c_visita['Visita']['avaliacao']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php
echo $this->Form->create('Visita');
if (isset($instituicao_id)) {
    echo $this->Form->input('estagio_id', array('label' => 'Instituição', 'options' => $instituicoes, 'default' => $instituicao_id));
} else {
    echo $this->Form->input('estagio_id', array('label' => 'Instituição', 'options' => $instituicoes));
}
echo $this->Form->input('data', array('dateFormat' => 'DMY'));
echo $this->Form->input('motivo');
echo $this->Form->input('responsavel');
echo $this->Form->input('descricao');
echo $this->Form->input('avaliacao');
echo $this->Form->end('Confirma');
?>
