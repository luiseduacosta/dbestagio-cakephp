<?= $this->element('submenu_supervisores'); ?>

<?= $this->Html->script("jquery.mask.min"); ?>

<script>

    $(document).ready(function () {

        $("#SupervisorCpf").mask("999999999-99");
        $("#SupervisorTelefone").mask("9999.9999");
        $("#SupervisorCelular").mask("99999.9999");
        $("#SupervisorCep").mask("99999-999");

    });

</script>

<?= $this->Form->create('Supervisor'); ?>
<div class="form-group row">
    <label for="SupervisorRegiao" class="col-sm-2 col-form-label">Região</label>
    <div class="col-sm-2">
        <?= $this->Form->input('regiao', ['label' => false, 'default' => 7, 'class' => 'form-control']); ?>
    </div>
    <label for="SupervisorCress" class="col-sm-1 col-form-label">CRESS</label>
    <div class="col-sm-4">
        <?= $this->Form->input('cress', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorNome" class="col-sm-2 col-form-label">Nome</label>
    <div class="col-sm-10">
        <?= $this->Form->input('nome', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <div class="form-group row">
        <label for="SupervisorCpf" class="col-sm-2 col-form-label">CPF</label>
        <div class="col-sm-10">
            <?= $this->Form->input('cpf', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>
<?php endif; ?>

<div class='form-group row'>
    <label for="SupervisorTelefone" class="col-sm-2 col-form-label">Telefone</label>
    <div class="col-sm-3">
        <?= $this->Form->input('codigo_tel', array('label' => false, 'default' => 21, 'class' => 'form-control')); ?>
    </div>
    <div class="col-sm-5">
        <?= $this->Form->input('telefone', ['label' => false, 'div' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class='form-group row'>
    <label for="SupervisorCelular" class="col-sm-2 col-form-label">Celular</label>
    <div class="col-sm-3">
        <?= $this->Form->input('codigo_cel', array('label' => false, 'default' => 21, 'class' => 'form-control')); ?>
    </div>
    <div class="col-sm-5">
        <?= $this->Form->input('celular', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorEmail" class="col-sm-2 col-form-label">E-mail</label>
    <div class="col-sm-10">
        <?= $this->Form->input('email', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<?php if ($this->Session->read('categoria') != 'estudante'): ?>
    <div class="form-group row">
        <label for="SupervisorCep" class="col-sm-2 col-form-label">CEP</label>
        <div class="col-sm-10">
            <?= $this->Form->input('cep', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorEndereco" class="col-sm-2 col-form-label">Endereço</label>
        <div class="col-sm-10">
            <?= $this->Form->input('endereco', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorBairro" class="col-sm-2 col-form-label">Bairro</label>
        <div class="col-sm-10">
            <?= $this->Form->input('bairro', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorMunicipio" class="col-sm-2 col-form-label">Município</label>
        <div class="col-sm-10">
            <?= $this->Form->input('municipio', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorEscola" class="col-sm-2 col-form-label">Escola</label>
        <div class="col-sm-10">
            <?= $this->Form->input('escola', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorAnoFormatura" class="col-sm-2 col-form-label">Ano da formatura</label>
        <div class="col-sm-10">
            <?= $this->Form->input('ano_formatura', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorOutrosEstudos" class="col-sm-2 col-form-label">Outros estudos</label>
        <div class="col-sm-10">
            <?= $this->Form->input('outros_estudos', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorAreaCurso" class="col-sm-2 col-form-label">Área do curso</label>
        <div class="col-sm-10">
            <?= $this->Form->input('area_curso', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorAnoCurso" class="col-sm-2 col-form-label">Ano do curso</label>
        <div class="col-sm-10">
            <?= $this->Form->input('ano_curso', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <?= $this->Form->label('curso_turma', 'Turma do curso de supervisores', ['class' => 'col-sm-2 col-form-label']); ?>
        <div class="col-sm-10">
            <?= $this->Form->input('curso_turma', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <?= $this->Form->label('num_inscricao', 'Número de inscrição', ['class' => 'col-sm-2 col-form-label']); ?>
        <div class="col-sm-10">
            <?= $this->Form->input('num_inscricao', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="SupervisorObservacoes" class="col-sm-2 col-form-label">Observações</label>
        <div class="col-sm-10">
            <?= $this->Form->input('observacoes', ['label' => false, 'class' => 'col-lg-2 col-form-label', 'textarea' => ['rows' => 5, 'cols' => 60], 'class' => 'form-control']); ?>
        </div>
    </div>
<?php endif; ?>

<br>
<div class='row justify-content-center'>
    <div class='col-auto'>
        <?= $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>