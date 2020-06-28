<?php // pr($visitas);      ?>

<script>
    $(document).ready(function () {

        var link = "<?= $this->Html->url(["controller" => "Visitas", "action" => "add/instituicao:"]); ?>";

        $("#VisitaEstagioId").change(function () {
            var instituicao_id = $(this).val();
            /* alert(instituicao_id); */
            window.location = link + instituicao_id;
        }
        })

    })
</script>

<h5>Informe de visita institucional</h5>

<?php if (!empty($visitas)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Instituição</th>
                    <th>Data</th>
                    <th>Motivo</th>
                    <th>Responsável</th>
                    <th>Avaliação</th>
                </tr>
            </thead>
            <?php foreach ($visitas as $c_visita): ?>
                <?php // pr($c_visita); ?>
                <tr>
                    <td><?php echo $c_visita['Visita']['id']; ?></td>
                    <td><?php echo $c_visita['Instituicao']['instituicao']; ?></td>
                    <td><?php echo $this->Html->link(date('d-m-Y', strtotime($c_visita['Visita']['data'])), '/Visitas/view/' . $c_visita['Visita']['id']); ?></td>
                    <td><?php echo $c_visita['Visita']['motivo']; ?></td>
                    <td><?php echo $c_visita['Visita']['responsavel']; ?></td>
                    <td><?php echo $c_visita['Visita']['avaliacao']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

<?php
echo $this->Form->create('Visita');
if (isset($instituicao_id)) {
    echo $this->Form->input('estagio_id', array('label' => 'Instituição', 'options' => $instituicoes, 'default' => $instituicao_id, 'class' => 'form-control'));
} else {
    echo $this->Form->input('estagio_id', array('label' => 'Instituição', 'options' => $instituicoes, 'class' => 'form-control'));
}
?>
<div class="form-group row">
    <label for="VisitaData" class="col-form-label col-sm-2">Data da visita</label>
    <div class="col-sm-6">
        <p style="line-height: 0,5%"></p>
        <?= $this->Form->input('data', array('label' => false, 'dateFormat' => 'DMY', 'class' => 'form-horizontal')); ?>
    </div>
</div>
<?php
echo $this->Form->input('motivo', ['class' => 'form-control']);
echo $this->Form->input('responsavel', ['class' => 'form-control']);
echo $this->Form->input('descricao', ['label' => 'Descripção', 'class' => 'form-control']);
echo $this->Form->input('avaliacao', ['class' => 'form-control']);
?>
<br>
<?php
echo $this->Form->submit('Confirma', ['class' => 'btn btn-primary']);
echo $this->Form->end();
?>
