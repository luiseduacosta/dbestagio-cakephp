
<h5>Atualizar</h5>
<?=
$this->Form->create("Userestagio", ['inputDefaults' => [
        'div' => ['class' => 'form-group row'],
        'label' => ['class' => 'col-lg-3 col-form-label'],
        'between' => '<div class = "col-lg-9">',
        'after' => '</div>',
        'class' => 'form-control']
]);
?>    
<?php echo $this->Form->input('email'); ?>
<?php echo $this->Form->input('categoria', array('label' => ['text' => 'Categoria: 2: Aluno, 3: Professor, 4: Supervisor', 'class' => 'col-lg-3 col-form-label'], 'options' => ['1' => 'Administrador', '2' => 'Estudante', '3' => 'Professor', '4' => 'Supervisor'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('password', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('numero', array('label' => ['text' => 'Digite o DRE, SIAPE, CRESS para estudante, professor ou supervisor respectivamente', 'class' => 'col-lg-3 col-form-label'], 'class' => 'form-control')); ?>
<?php echo $this->Form->input('aluno_id', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('alunonovo_id', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('docente_id', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('supervisor_id', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('Atualizar', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-success position-static']); ?>
<?php echo $this->Form->end(''); ?>
