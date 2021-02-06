<?php
// pr($cress);
// pr($periodos);
// pr($periodoatual);
?>

<script>
    $(document).ready(function () {

        var url = "<?= $this->Html->url(['controller' => 'Alunos', 'action' => 'planilhacress/periodo:']); ?>";

        $("#AlunoPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = url + periodo;
        })
    });
</script>

<?= $this->element('submenu_administracao'); ?>

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

<div class='table-responsive'>
<table class='table table-hover table-responsive'>
    <caption style="caption-side: top;">Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª Região</caption>
    <thead class="thead-light">
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
    </thead>
    <tbody>
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
    </tbody>
    <tfoot></tfoot>
</table>
</div>