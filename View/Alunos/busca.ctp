<?php
// pr($alunos);
// die();
?>

<?= $this->element('submenu_alunos'); ?>

<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por nome de estudante</h1>

    <?php $this->Paginator->options(array('url' => array($nome))); ?>

    <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>

    <div class='table-responsive'>
        <table class="table table-striped table-hover table-responsive">
            <caption>Resultado da busca</caption>
            <thead class="thead-light">
                <tr>
                    <th>Nome</th>
                </tr>                
            </thead>
            <?php foreach ($alunos as $c_aluno): ?>
                <tr>
                    <td><?php echo $this->Html->link($c_aluno['Aluno']['nome'], '/alunos/view/' . $c_aluno['Aluno']['id']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php else: ?>

    <h1>Busca por nome</h1>

    <?php echo $this->Form->create('Aluno'); ?>
    <?php echo $this->Form->input('nome', ['label' => 'Digite o nome do estudante', 'class' => 'form-control']); ?>
    <br>
    <?php echo $this->Form->input('Confirma', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-primary position-static']); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
