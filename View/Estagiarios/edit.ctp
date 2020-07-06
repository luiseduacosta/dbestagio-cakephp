<?php // pr($aluno);    ?>

<script>
    $(document).ready(function () {
        $("#EstagiarioIdInstituicao").change(function () {
            var instituicao_id = $(this).val();
            $("#EstagiarioIdSupervisor").load("/mural/Instituicoes/seleciona_supervisor/" + instituicao_id, {id: $(this).val(), ajax: "true"});
            /* alert(instituicao_id); */
        })
    });
</script>

<h5><?php echo $aluno; ?></h5>

<?= $this->Form->create('Estagiario'); ?>

<?= $this->Form->input('Estagiario.registro', array('type' => 'hidden')); ?>

<div class="form-group row">
    <div class="col-form-label col-sm-3">Ajuste curricular 2020</div>
    <div class='col-sm-3'>
        <div class ='form-check'>
            <?= $this->Form->input('Estagiario.ajustecurricular2020', array('div' => 'col-sm-3', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('0' => 'Não', '1' => 'Sim'), 'class' => 'form-check-input')); ?>
        </div>
    </div>
</div>

<div class="form-group row">
    <?= $this->Form->label('Estagiario.periodo', 'Período', ['class' => 'col-form-label col-sm-3']); ?>
    <div class='col-sm-3'>
        <div class ='form-check'>'
            <?php echo $this->Form->input('Estagiario.periodo', array('type' => 'select', 'label' => false, 'options' => $periodos, 'class' => 'form-control')); ?>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-form-label col-sm-3">Nível</div>
    <div class='col-sm-3'>
        <div class ='form-check'>
            <?= $this->Form->input('Estagiario.nivel', array('div' => 'col-sm-3', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '9' => 'Não obrigatório'), 'class' => 'form-check-input')); ?>
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
    <?php echo $this->Form->input('Estagiario.tc_solicitacao', array('type' => 'date', 'label' => false, 'dateFormat' => 'DMY', 'empty' => TRUE, 'class' => 'form-horizontal')); ?>
</div>

<?php echo $this->Form->input('Estagiario.instituicao_id', array('label' => 'Instituição', 'options' => $instituicoes, 'default' => 0, 'empty' => [0 => 'Selecione'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.supervisor_id', array('label' => 'Superviso(a)r', 'options' => $supervisores, 'default' => 0, 'empty' => [0 => 'Selecione'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.docente_id', array('label' => 'Professo(a)r', 'options' => $professores, 'default' => 0, 'empty' => [0 => 'Selecione'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.areaestagio_id', array('label' => 'Área temática', 'options' => $areas, 'default' => 0, 'empty' => [0 => 'Seleciona'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.nota', array('label' => 'Nota', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.ch', array('label' => 'Carga horária', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('Estagiario.observacoes', array('label' => 'Observações', 'class' => 'form-control')); ?>
</fieldset>
<br>
<?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-primary']); ?>
<?php echo $this->Form->end(); ?>
