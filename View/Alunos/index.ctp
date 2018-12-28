<?php echo $this->Html->link('Estagiários','/Estagiarios/index'); ?>

<div align='center'>
<h1>Estudantes</h1>

<?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->last(' Último >> ', null, null, array('class'=>'disabled')); ?>

<br/>
<?php echo $this->Paginator->numbers(); ?>
</div>

<table border=1>

<tr>
<th>
<?php if ($this->Session->read('categoria') != 'estudante'): ?>    
    <th><?php echo $this->Paginator->sort('Registro','registro'); ?></th>
<?php endif; ?>

<th><?php echo $this->Paginator->sort('Nome','nome'); ?></th>

<?php if ($this->Session->read('categoria') != 'estudante'): ?>    
    <th><?php echo $this->Paginator->sort('Nascimento','nascimento'); ?></th>
    <th><?php echo $this->Paginator->sort('CPF','cpf'); ?></th>
<?php endif; ?>

<th><?php echo $this->Paginator->sort('Email','email'); ?></th>

<?php if ($this->Session->read('categoria') != 'estudante'): ?>    
    <th><?php echo $this->Paginator->sort('Telefone','telefone'); ?></th>
    <th><?php echo $this->Paginator->sort('Celular','celular'); ?></th>
<?php endif; ?>

</tr>

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
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
