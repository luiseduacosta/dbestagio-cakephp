<?php ?>

<script>

    $(document).ready(function () {

        $("#MuralCargaHoraria").mask("99");
        $("#MuralHorarioSelecao").mask("99:99");

    });
</script>

<h5>Solicitação de vagas para estágio</h5>

<?php echo $this->Form->create('Muralestagio', ['class' => 'form-horizontal']); ?>
<div class='col-2'>
    <?php echo $this->Form->input('periodo', array('label' => 'Período', 'value' => $periodo, 'class' => 'form-control')); ?>
</div>
<div class='col-12'>
    <?php echo $this->Form->input('estagio_id', array('label' => ['text' => 'Instituição (se a instituição não está cadastrada, tem que cadastrar neste link: ' . $this->Html->link("Instituições", "/Instituicoes/add") . ')', 'class' => 'control-label'], 'type' => 'select', 'options' => $instituicoes, 'class' => 'form-control')); ?>
</div>
<div class='col-4'>
    <?php echo $this->Form->input('convenio', array('label' => 'Convênio com a UFRJ', 'type' => 'select', 'options' => array('0' => 'Não', '1' => 'Sim'), 'class' => 'form-control')); ?>
</div>
<div class='col-3'>
    <?php echo $this->Form->input('vagas', array('label' => 'Vagas (digitar somente números inteiros)', 'default' => 0, 'class' => 'form-control')); ?>
</div>
<div class="col-12">
    <?php echo $this->Form->input('beneficios', ['class' => 'form-control']); ?>
</div>
<div class="col-3">
    <?php echo $this->Form->input('final_de_semana', array('label' => 'Estágio de final de semana', 'type' => 'select', 'options' => array('0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente'), 'selected' => 0, 'class' => 'form-control')); ?>
</div>
<div class="col-3">
    <?php echo $this->Form->input('cargaHoraria', ['class' => 'form-control']); ?>
</div>
<div class='col-12'>
    <?php echo $this->Form->input('requisitos', array('rows' => 4, 'class' => 'form-control')); ?>
</div>
<div class='col-6'>
    <?php echo $this->Form->input('id_area', array('label' => 'Área de OTP', 'type' => 'select', 'options' => $areas, 'class' => 'form-control')); ?>
</div>
<div class='col-12'>
    <?php echo $this->Form->input('horario', array('label' => 'Horário da OTP', 'type' => 'select', 'options' => array('D' => 'Diurno', 'N' => 'Noturno', 'A' => 'Ambos'), 'class' => 'form-control')); ?>
</div>
<div class='col-12'>
    <?php echo $this->Form->input('docente_id', array('label' => 'Professor', 'type' => 'select', 'options' => $professores, 'class' => 'form-control')); ?>
</div>
<div class='col-6'>
    <label for='MuralestagiosDadaSelecao' class='control-label'>Data da seleção</label>
</div>
<div class='col-3'>
    <?php echo $this->Form->input('dataSelecao', array('label' => false, 'dateFormat' => 'DMY', 'minYear' => '2000', 'empty' => TRUE, 'class' => 'form-horizontal')); ?>
</div>
<div class='col-3'>
    <?php echo $this->Form->input('horarioSelecao', ['class' => 'form-control']); ?>
</div>
<div class="col-6">
    <?php echo $this->Form->input('localSelecao', ['class' => 'form-control']); ?>
</div>
<div class='col-3'>
    <?php echo $this->Form->input('formaSelecao', array('label' => 'Forma de seleção', 'type' => 'select', 'options' => array('0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras'), 'class' => 'form-control')); ?>
</div>
<div class='col-6'>
    <label for='MuralestagiosDadaInscricao' class='control-label'>Data final da inscrição</label>
</div>
<div class='col-6'>
    <?php echo $this->Form->input('dataInscricao', array('label' => false, 'dateFormat' => 'DMY', 'minYear' => '2000', 'empty' => TRUE, 'class' => 'form-horizontal')); ?>
</div>
<div class='col-3'>
    <?php echo $this->Form->input('contato', ['class' => 'form-control']); ?>
</div>
<div class='col-6'>
    <?php echo $this->Form->input('email', array('label' => 'Email para envio da lista de inscrições', 'class' => 'form-control')); ?>
</div>
<div class="col-6">
    <?php echo $this->Form->input('datafax', array('type' => 'hidden', 'label' => 'Data de envio do email (preenchimento automático)', 'dateFormat' => 'DMY', 'empty' => TRUE, 'class' => 'form-horizontal')); ?>
</div>
<div class="col-6">
    <?php echo $this->Form->input('localInscricao', array('label' => 'Inscrição na Coordenação de Estágio ou diretamente na instituição', 'type' => 'select', 'options' => array('0' => 'Mural da Coordenação de Estágio/ESS', '1' => 'Diretamente na Instituição'), 'class' => 'form-control')); ?>
</div>
<div class="col-12">
    <?php echo $this->Form->input('outras', array('label' => 'Outras informações', 'class' => 'form-control')); ?>
</div>
<br>
<div class="form-group">
    <?php echo $this->Form->submit('Confirmar', ['class' => 'btn btn-primary']); ?>
</div>
<?php echo $this->Form->end(); ?>
