<?php // pr($estagiarios); 
// die('periodos');
?>

<script>
    $(document).ready(function () {
        $("#EstagiarioIdInstituicao").change(function () {
            var instituicao_id = $(this).val();
            $("#EstagiarioIdSupervisor").load("/mural/Instituicoes/seleciona_supervisor/" + instituicao_id, {id: $(this).val(), ajax: "true"});
            /* alert(instituicao_id); */
        })
    });
</script>

<?= $this->Html->script("jquery.mask.min"); ?>

<script>
    $(document).ready(function () {

        $("#EstagiarioNota").mask("00.00");
        $("#EstagiarioCh").mask("000");

    });
</script>

<fieldset>
    <legend>Estudante</legend>

    <h5>
        <?php
        if ($estagiarios) {
            echo $estagiarios[array_key_first($estagiarios)]['Estudante']['nome'];
        } else {
            echo $estagiario_sem_estagio['Estudante']['nome'];
            // echo "Estudante sem estágio";
        }
        ?>
    </h5>

</fieldset>

<h5>Estágios cursados</h5>

<?php if (!isset($proximo_nivel)) $proximo_nivel = 1; ?>

<?php if (isset($estagiarios)): ?>
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
        <caption style="caption-side: top;">Estágios cursados</caption>
        <tr>
            <th>Excluir</th>
            <th>Editar</th>
            <th>Ajuste curricular</th>
            <th>Período</th>
            <th>Nível</th>
            <th>Turno</th>
            <th>TC</th>
            <th>Solicitação do TC</th>
            <th>Instituição</th>
            <th>Supervisor</th>
            <th>Professor</th>
            <th>Área</th>
            <th>Nota</th>
            <th>CH</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estagiarios as $c_estagio): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_estagio['Estagiario']['id']); ?>
                </td>
                <td><?php echo $c_estagio['Estagiario']['ajustecurricular2020'] ?></td>
                <td><?php echo $c_estagio['Estagiario']['periodo'] ?></td>
                <td><?php echo $c_estagio['Estagiario']['nivel']; ?></td>
                <td><?php echo $c_estagio['Estagiario']['turno']; ?></td>
                <td><?php echo $c_estagio['Estagiario']['tc']; ?></td>
                <td><?php echo $c_estagio['Estagiario']['tc_solicitacao']; ?></td>
                <td><?php echo $c_estagio['Instituicao']['instituicao'] ?></td>
                <td><?php echo $c_estagio['Supervisor']['nome'] ?></td>
                <td><?php echo $c_estagio['Professor']['nome'] ?></td>
                <td><?php echo $c_estagio['Areaestagio']['area'] ?></td>
                <td><?php echo $c_estagio['Estagiario']['nota'] ?></td>
                <td><?php echo $c_estagio['Estagiario']['ch'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>

    </tfoot>
    </table>
<?php endif; ?>

<?php
echo $this->Form->create('Estagiario');
?>

<fieldset>
    <legend>Inserir novo Estágio</legend>
    <?php
    if ($estagiarios) {
        echo $this->Form->input('Estagiario.aluno_id', array('type' => 'hidden', 'value' => $estagiarios[0]['Estagiario']['aluno_id']));
        echo $this->Form->input('Estagiario.registro', array('type' => 'hidden', 'value' => $estagiarios[0]['Estagiario']['registro']));
    } else {
        echo $this->Form->input('Estagiario.estudante_id', array('type' => 'hidden', 'value' => $estagiario_sem_estagio['Estudante']['id']));
        echo $this->Form->input('Estagiario.registro', array('type' => 'hidden', 'value' => $estagiario_sem_estagio['Estudante']['registro']));
    }
    ?>

    <div class="form-group row">
        <?= $this->Form->label('Estagiario.periodo', 'Período', ['class' => 'col-form-label col-sm-3']); ?>
        <div class='col-sm-3'>
            <div class ='form-check'>'
                <?php echo $this->Form->input('Estagiario.periodo', array('type' => 'select', 'label' => false, 'options' => $periodos, 'selected' => $periodo_atual, 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-form-label col-sm-3">Ajuste curricular 2020</div>
        <div class='col-sm-3'>
            <div class ='form-check'>
                <?= $this->Form->input('Estagiario.ajustecurricular2020', array('div' => 'col-sm-3', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('0' => 'Não', '1' => 'Sim'), 'default' => '0', 'class' => 'form-check-input')); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-form-label col-sm-3">Nível</div>
        <div class='col-sm-3'>
            <div class ='form-check'>
                <?= $this->Form->input('Estagiario.nivel', array('div' => 'col-sm-3', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '9' => 'Não obrigatório'), 'default' => $proximo_nivel, 'class' => 'form-check-input')); ?>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class='col-form-label col-sm-3'>Turno</div>
        <div class='col-sm-3'>
            <div class="form-check">
                <?= $this->Form->input('Estagiario.turno', array('div' => 'col-sm-3', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado'), 'default' => 'D', 'class' => 'form-check-input')); ?>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-form-label col-sm-3">Termo de compromisso</div>
        <div class ='form-check'>
            <?= $this->Form->input('Estagiario.tc', array('div' => 'col-sm-3', 'type' => 'radio', 'label' => ['class' => 'form-check-label col-sm-4'], 'legend' => FALSE, 'options' => array('0' => 'Não', '1' => 'Sim'), 'default' => '0', 'class' => 'form-check-input')); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $this->Form->label('Estagiario.tc_solicitacao', 'Data de solicitação do TC (inserida automáticamente quando o estudante solicita o TC)', ['class' => 'form-label-control']); ?>
        <?= $this->Form->input('Estagiario.tc_solicitacao', array('type' => 'date', 'label' => false, 'dateFormat' => 'DMY', 'monthNames' => $meses, 'empty' => TRUE, 'class' => 'form-horizontal')); ?>
    </div>

    <?php echo $this->Form->input('Estagiario.instituicaoestagio_id', array('label' => 'Instituição', 'options' => $instituicoes, 'default' => 0, 'empty' => [0 => 'Selecione'], 'class' => 'form-control')); ?>
    <?php echo $this->Form->input('Estagiario.supervisor_id', array('label' => 'Superviso(a)r', 'options' => $supervisores, 'default' => 0, 'empty' =>[0 => 'Selecione'], 'class' => 'form-control')); ?>
    <?php echo $this->Form->input('Estagiario.docente_id', array('label' => 'Professo(a)r', 'options' => $professores, 'default' => 0, 'empty' => [0 => 'Selecione'], 'class' => 'form-control')); ?>
    <?php echo $this->Form->input('Estagiario.id_area', array('label' => 'Área temática', 'options' => $areas, 'default' => 0, 'empty' => [0 => 'Seleciona'], 'class' => 'form-control')); ?>
    <?php echo $this->Form->input('Estagiario.nota', array('label' => 'Nota', 'class' => 'form-control')); ?>
    <?php echo $this->Form->input('Estagiario.ch', array('label' => 'Carga horária', 'class' => 'form-control')); ?>
    <?php echo $this->Form->input('Estagiario.observacoes', array('label' => 'Observações', 'class' => 'form-control')); ?>
</fieldset>
<br>
<?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
<?php echo $this->Form->end(); ?>
