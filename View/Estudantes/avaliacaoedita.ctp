<?php ?>

<script>
    $(document).ready(function () {

        $("#SupervisorCpf").mask("999999999-99");
        $("#SupervisorTelefone").mask("9999.9999");
        $("#SupervisorCelular").mask("9999.9999");
        $("#SupervisorCep").mask("99999-999");

    });
</script>
<?= $this->element('submenu_estudantes'); ?>
<br>

<div class='card text-black bg-light'>
    <div class='card-header'>
        Estudante: <?php echo $aluno; ?>        
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 order-lg-1 order-1">
                Registro: <?php echo $registro; ?>
            </div>
            <div class="col-lg-3 order-lg-2 order-2">

            </div>
            <div class="col-lg-3 order-lg-3 order-3">
                Período: <?php echo $periodo; ?>
            </div>
            <div class="col-lg-3 order-lg-4 order-4">
                Nível: <?php echo $nivel; ?>
            </div>
            <div class="col-lg-12 order-lg-5 order-5">
                Professor: <?php echo $professor; ?>
            </div>
            <div class="col-lg-12 order-lg-6 order-6">
                Instituição: <?php echo $instituicao; ?>
            </div>
            <div class="col-lg-12 order-lg-7 order-7">
                Supervisor: <?php echo $supervisor; ?>
            </div>
        </div>
    </div>
</div>

<h5>Preencha todos os campos do formulário</h5>

<?= $this->Form->create('Supervisor'); ?>
<div class="form-row">
    <div class="col-1">
        <?= $this->Form->input('regiao', ['default' => 7, 'class' => 'form-control']); ?>
    </div>
    <div class="col-2">    
        <?= $this->Form->input('cress', ['class' => 'form-control']); ?>
    </div>
    <div class="col">    
        <?= $this->Form->input('nome', ['class' => 'form-control']); ?>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <?= $this->Form->input('codigo_tel', ['default' => 21, 'class' => 'form-control']); ?>
    </div>
    <div class="col">    
        <?= $this->Form->input('telefone', ['class' => 'form-control']); ?>
    </div>
    <div class="col">    
        <?= $this->Form->input('codigo_cel', ['default' => 21, 'class' => 'form-control']); ?>
    </div>
    <div class="col">    
        <?= $this->Form->input('celular', ['class' => 'form-control']); ?>
    </div>
</div>
<div class='form-row'>
    <div class="col">    
        <?= $this->Form->input('email', ['class' => 'form-control']); ?>
    </div>
</div>
<br>
<?= $this->Form->input('registro', ['type' => 'hidden', 'value' => $registro, 'class' => 'form-control']); ?>
<?= $this->Form->input('supervisor_id', ['type' => 'hidden', 'value' => $supervisor_id, 'class' => 'form-control']); ?>
<?= $this->Form->input('Confirma', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-success position-static']); ?>
<?= $this->Form->end(); ?>
