<?php
/* 
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $html->link('Inserir','/Instituicaos/add/');
    echo " | ";
    echo $html->link('Buscar','/Instituicaos/busca/');
    ?>
<?php else: ?>
    <?php
    echo $html->link('Buscar','/Instituicaos/busca/');
    ?>
<?php endif; ?>

<div align="center">
<?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->prev('< Anterior ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->next(' Posterior > ', null, null, array('class'=>'disabled')); ?>
<?php echo $this->Paginator->last(' Último >> ', null, null, array('class'=>'disabled')); ?>

<br />

<?php echo $this->Paginator->numbers(); ?>

</div>

<table>
    <thead>
        <tr>
            <th>
                <?php echo $this->Paginator->sort('Id', 'Instituicao.id'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituição', 'Instituicao.instituicao'); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($instituicoes as $c_instituicao): ?>
        <tr>
            <td><?php echo $html->link($c_instituicao['Instituicao']['id'], '/Instituicaos/view/' . $c_instituicao['Instituicao']['id']); ?></td>
            <td><?php echo $html->link($c_instituicao['Instituicao']['instituicao'], '/Instituicaos/view/' . $c_instituicao['Instituicao']['id']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
