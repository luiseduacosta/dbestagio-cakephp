<p>
<?php echo $this->Html->link('Inserir aluno','/alunos/add'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por Nome','/alunos/busca'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por DRE','/alunos/busca_dre'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por Email','/alunos/busca_email'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por CPF','/alunos/busca_cpf'); ?>
</p>


<?php if (isset($alunos)): ?>

<h1>Resultado da busca por DRE</h1>

    <?php foreach ($alunos as $c_alunos): ?>
    <?php if (isset($c_alunos['Aluno']['nome'])): ?>
        <?php echo $this->Html->link($c_alunos['Aluno']['nome'],'/Alunos/view/'.$c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php else: ?>
        <?php echo $this->Html->link($c_alunos['Alunonovo']['nome'],'/Alunonovos/view/'.$c_alunos['Alunonovo']['id']) . '<br>'; ?>
    <?php endif; ?>    
    <?php endforeach; ?>

<?php else: ?>

<h1>Busca por DRE</h1>

    <?php echo $this->Form->create('Aluno'); ?>
    <?php echo $this->Form->input('registro', array('label' => 'Digite o DRE do aluno', 'maxsize' => 9)); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
