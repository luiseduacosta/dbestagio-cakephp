<?= $this->element('submenu_alunos'); ?>

<div align='center'>
    <h1>Estudantes</h1>

    <?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

    <br/>
    <?php echo $this->Paginator->numbers(); ?>
</div>

<div class='table-responsive'>
<table class='table table-striped table-hover table-responsive'>
    <thead class="thead-light">
        <tr>

            <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                <th><?php echo $this->Paginator->sort('registro', 'Registro'); ?></th>
            <?php endif; ?>

            <th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>

            <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                <th><?php echo $this->Paginator->sort('nascimento', 'Nascimento'); ?></th>
                <th><?php echo $this->Paginator->sort('cpf', 'CPF'); ?></th>
            <?php endif; ?>

            <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>

            <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                <th><?php echo $this->Paginator->sort('telefone', 'Telefone'); ?></th>
                <th><?php echo $this->Paginator->sort('celular', 'Celular'); ?></th>
            <?php endif; ?>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($alunos as $aluno): ?>
            <tr>

                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <td style='text-align:center'>
                        <?php echo $this->Html->link($aluno['Aluno']['registro'], '/Alunos/view/' . $aluno['Aluno']['id']); ?>
                    </td>
                <?php endif; ?>

                <td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>

                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <td style='text-align:center'><?php echo $aluno['Aluno']['nascimento']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Aluno']['cpf']; ?></td>
                <?php endif; ?>

                <td style='text-align:left'><?php echo $aluno['Aluno']['email']; ?></td>

                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <td style='text-align:left'><?php echo $aluno['Aluno']['telefone']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Aluno']['celular']; ?></td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot></tfoot>
</table>
</div>

<?php
echo $this->Paginator->counter(array(
    'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
));
?>
