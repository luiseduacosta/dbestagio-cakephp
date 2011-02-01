<p>
<?php echo $html->link('Inserir aluno','/alunos/add'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Busca por Nome','/alunos/busca'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Busca por DRE','/alunos/busca_dre'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Busca por Email','/alunos/busca_email'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Busca por CPF','/alunos/busca_cpf'); ?>
</p>


<?php if (isset($alunos)): ?>

<h1>Resultada da busca por nome de estudante</h1>

    <?php $paginator->options(array('url'=>array($nome))); ?>

    <?php echo $paginator->prev('<< Anterior ', null, null, array('class'=>'disabled')); ?>
    <?php echo $paginator->numbers(); ?>
    <?php echo $paginator->next(' Posterior >> ', null, null, array('class'=>'disabled')); ?>

    <table>
        <?php foreach ($alunos as $c_aluno): ?>
        <tr>
            <td style='text-align:left'><?php echo $html->link($c_aluno['Aluno']['nome'],'/alunos/view/'.$c_aluno['Aluno']['id']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

<h1>Busca por nome</h1>

    <?php echo $form->create('Aluno', array('controller'=>'Alunos','action'=>'busca')); ?>
    <?php echo $form->input('nome',array('label'=>'Digite o nome do aluno')); ?>
    <?php echo $form->end('Confirma'); ?>

<?php endif; ?>
