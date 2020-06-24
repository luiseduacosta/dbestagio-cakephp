<?= $this->element('submenu_estudantes'); ?>

<?php
// pr($alunos);
// die();
?>
<?php if (isset($alunos)): ?>

    <h5>Resultado da busca por nome de estudante</h5>

    <?php $this->Paginator->options(array('url' => array($nome))); ?>

    <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>


    <?php foreach ($alunos as $c_aluno): ?>
        <div class="row">        
            <div class="col">
                <p style='text-align:left'><?php echo $this->Html->link($c_aluno['Estudante']['nome'], '/Estudantes/view/' . $c_aluno['Estudante']['id']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>


<?php else: ?>

    <h5>Busca por nome</h5>

    <?php echo $this->Form->create('Estudante'); ?>
    <div class="form-group">
        <?php echo $this->Form->input('nome', ['label' => 'Digite o nome do estudante', 'class' => 'form-control']); ?>
    </div>
    <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-primary position-static']); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
