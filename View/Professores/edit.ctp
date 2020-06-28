<?= $this->element('submenu_professores'); ?>

<script>
    $(document).ready(function () {

        $("#ProfessorCpf").mask("999999999-99");
        $("#ProfessorTelefone").mask("9999.9999");
        $("#ProfessorCelular").mask("99999.9999");

    });
</script>

<?php
echo $this->Form->create('Professor', [
    'inputDefaults' => array(
        'div' => false,
        'before' => '<div class = "form-group row">',
        'label' => ['class' => 'col-lg-2 col-form-label'],
        'between' => '<div class = "col-lg-6">',
        'input' => ['type' => 'text'],
        'after' => '</div></div>'
    )
]);
?>

<?php echo $this->Form->input('siape', ['class' => 'form-control']); ?>
<?php echo $this->Form->input('nome', ['class' => 'form-control']); ?>

<?php
// echo $this->Form->input('cpf', ['class' => 'form-control']);
// echo $this->Form->input('datanascimento', array('dateFormat'=>'DMY', 'empty'=>TRUE, ['class' => 'form-control']));
// echo $this->Form->input('localnascimento', ['class' => 'form-control']);
// echo $this->Form->input('sexo', array('options'=>array('1'=>'Masculino', '2'=>'Feminino'), ['class' => 'form-control']));
?>

<?php echo $this->Form->input('telefone', ['class' => 'form-control']); ?>
<?php echo $this->Form->input('celular', ['class' => 'form-control']); ?>
<?php echo $this->Form->input('email', ['class' => 'form-control']); ?>

<?php
// echo $this->Form->input('homepage', ['class' => 'form-control']);
// echo $this->Form->input('redesocial', ['class' => 'form-control']);
?>

<?php echo $this->Form->input('curriculolattes', ['class' => 'form-control']); ?>

<?php
// echo $this->Form->input('atualizacaolattes', array('dateFormat'=>'DMY', 'empty'=>TRUE, ['class' => 'form-control']));
// echo $this->Form->input('curriculosigma', ['class' => 'form-control']);
// echo $this->Form->input('pesquisadordgp', ['class' => 'form-control']);
// echo $this->Form->input('formacaoprofissional', ['class' => 'form-control']);
// echo $this->Form->input('universidadedegraduacao', ['class' => 'form-control']);
// echo $this->Form->input('anoformacao', ['class' => 'form-control']);
// echo $this->Form->input('mestradoarea', ['class' => 'form-control']);
// echo $this->Form->input('mestradouniversidade', ['class' => 'form-control']);
// echo $this->Form->input('mestradoanoconclusao', ['class' => 'form-control']);
// echo $this->Form->input('doutoradoarea', ['class' => 'form-control']);
// echo $this->Form->input('doutoradouniversidade', ['class' => 'form-control']);
// echo $this->Form->input('doutoradoanoconclusao', ['class' => 'form-control']);
?>

<?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); ?>
<?php date_default_timezone_set('America/Sao_Paulo'); ?>
<?php echo $this->Form->input('dataingresso', ['type' => 'date', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 80, 'maxYear' => date('Y'), 'empty' => TRUE, 'class' => 'form-horizontal date']); ?>

<?php
// echo $this->Form->input('formaingresso', ['class' => 'form-control']);
// echo $this->Form->input('tipocargo', ['class' => 'form-control']);
// echo $this->Form->input('categoria', array('label'=>'Categoria (Adjunto, etc.)', ['class' => 'form-control']));
// echo $this->Form->input('regimetrabalho', ['class' => 'form-control']);
?>

<?php echo $this->Form->input('departamento', ['options' => ['Fundamentos' => 'Fundamentos', 'Metodos' => 'Métodos e técnicas', 'Politicas' => 'Política Social'], 'class' => 'form-control']); ?>

<?php
// echo $this->Form->input('dataegresso', array('dateFormat'=>'DMY', 'empty'=>TRUE, ['class' => 'form-control']));
// echo $this->Form->input('motivoegresso', ['class' => 'form-control']);
?>

<?php echo $this->Form->input('observacoes', ['class' => 'form-control']); ?>
<br>

<div class='row justify-content-center'>
    <div class='col-8'>    
        <?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-primary']); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>

