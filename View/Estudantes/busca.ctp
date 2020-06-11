<p>
    <?php echo $this->Html->link('Inserir estudante', '/Estudantes/add'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Busca por Nome', '/Estudantes/busca'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Busca por DRE', '/Estudantes/busca_dre'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Busca por Email', '/Estudantes/busca_email'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Busca por CPF', '/Estudantes/busca_cpf'); ?>
</p>

<?php
// pr($alunos);
// die();
?>
<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por nome de estudante</h1>

    <?php $this->Paginator->options(array('url' => array($nome))); ?>

    <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>

    <table>
        <?php foreach ($alunos as $c_aluno): ?>
            <tr>
                <td style='text-align:left'><?php echo $this->Html->link($c_aluno['Estudante']['nome'], '/Estudantes/view/' . $c_aluno['Estudante']['id']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <h1>Busca por nome</h1>

    <?php echo $this->Form->create('Estudante'); ?>
    <?php echo $this->Form->input('nome', array('label' => 'Digite o nome do estudante')); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
