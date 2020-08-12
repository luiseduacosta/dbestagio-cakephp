<?php // pr($aluno); ?>

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

<h5><?php echo $aluno; ?></h5>

<?= $this->Form->create('Estagiario'); ?>

<?= $this->Form->input('Estagiario.registro', array('type' => 'hidden')); ?>
<?= $this->Form->input('Estagiario.aluno_id', array('type' => 'hidden')); ?>
<?= $this->Form->input('Estagiario.estudante_id', array('type' => 'hidden')); ?>

<div class="form-group row">
    <div class="col-form-label col-sm-3">Ajuste curricular</div>
    <div class='col-sm-3'>
        <?= $this->Form->input('Estagiario.ajustecurricular2020', array('div' => 'form-check form-check-inline', 'type' => 'radio', 'legend' => False, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'class' => 'form-check-input')); ?>
    </div>
</div>

<div class="form-group row">
    <div class="col-form-label col-sm-3">Período</div>
    <div class='col-sm-3'>
        <?php echo $this->Form->input('Estagiario.periodo', array('type' => 'select', 'label' => false, 'options' => $periodos, 'required', 'class' => 'form-control-input')); ?>
    </div>
</div>

<div class="form-group row">
    <div class="col-form-label col-sm-3">Nível</div>
    <div class='col-sm-3'>
        <div class ='form-check'>
            <?= $this->Form->input('Estagiario.nivel', array('div' => 'form-check form-check-inline', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '9' => 'Não obrigatório'), 'required', 'class' => 'form-check-input')); ?>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class='col-form-label col-sm-3'>Turno</div>
    <div class='col-sm-3'>
        <div class="form-check">
            <?= $this->Form->input('Estagiario.turno', array('div' => 'form-check form-check-inline', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado'), 'default' => 'D', 'required', 'class' => 'form-check-input')); ?>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-form-label col-sm-3">Termo de compromisso</div>
    <div class ='form-check'>
        <?= $this->Form->input('Estagiario.tc', array('div' => 'form-check form-check-inline', 'type' => 'radio', 'label' => ['class' => 'form-check-label col-sm-4'], 'legend' => FALSE, 'options' => array('0' => 'Não', '1' => 'Sim'), 'default' => '0', 'class' => 'form-check-input')); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label('Estagiario.tc_solicitacao', 'Data de solicitação do TC (inserida automáticamente quando o estudante solicita o TC)', ['class' => 'form-label-control']); ?>
    <?php echo $this->Form->input('Estagiario.tc_solicitacao', array('type' => 'date', 'label' => false, 'dateFormat' => 'DMY', 'monthNames' => $meses, 'empty' => TRUE, 'class' => 'form-horizontal')); ?>
</div>

<?php echo $this->Form->input('Estagiario.instituicaoestagio_id', array('label' => 'Instituição', 'options' => $instituicoes, 'default' => 0, 'empty' => [0 => 'Selecione'], 'required', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.supervisor_id', array('label' => 'Superviso(a)r', 'options' => $supervisores, 'default' => 0, 'empty' => [0 => 'Selecione'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.docente_id', array('label' => 'Professo(a)r', 'options' => $professores, 'default' => 0, 'empty' => [0 => 'Selecione'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.areaestagio_id', array('label' => 'Área temática', 'options' => $areas, 'default' => 0, 'empty' => [0 => 'Seleciona'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.nota', array('label' => 'Nota', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.ch', array('label' => 'Carga horária', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.observacoes', array('label' => 'Observações', 'class' => 'form-control')); ?>
</fieldset>
<br>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>