<?php
// pr($instituicoes);
/* 
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

?>

<?php
echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

$("#InstituicaoPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        window.location="/mycake/Instituicaos/index/periodo:"+periodo;
	})

})

', array("inline"=>false)

);
?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Instituicao', array('controller' => 'Instituicao', 'action'=>'index')); ?>
    <?php echo $this->Form->input('periodo', array('type'=>'select', 'label'=>array('text'=>'Período ', 'style'=>'display: inline'), 'options'=> $todosPeriodos, 'default'=>$periodo, 'empty'=>true)); ?>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Inserir','/Instituicaos/add/');
    echo " | ";
    echo $this->Html->link('Buscar','/Instituicaos/busca/');
    echo " || ";
    echo $this->Html->link('Área','/AreaInstituicaos/index/');
    echo " | ";
    echo $this->Html->link('Natureza','/Instituicaos/natureza/');
    ?>
<?php else: ?>
    <?php
    echo $this->Html->link('Buscar','/Instituicaos/busca/');
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
                <?php echo $this->Paginator->sort('Instituicao.id', 'Id'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.convenio', 'Convênio'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.virtualMaxPeriodo', 'Último estágio'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.virtualEstudantes', 'Estudantes'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.virtualSupervisores', 'Supervisores'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('AreaInstituicao.area', 'Área'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.natureza', 'Natureza'); ?>
            </th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($instituicoes as $c_instituicao): ?>
        <tr>
            <td><?php echo $this->Html->link($c_instituicao['Instituicao']['id'], '/Instituicaos/view/' . $c_instituicao['Instituicao']['id']); ?></td>
            <td><?php echo $this->Html->link($c_instituicao['Instituicao']['instituicao'], '/Instituicaos/view/' . $c_instituicao['Instituicao']['id']); ?></td>
            <td>
                <?php
                if ($c_instituicao['Instituicao']['convenio']):
                    echo $this->Html->link($c_instituicao['Instituicao']['convenio'], 'http://www.pr1.ufrj.br/estagios/info.php?codEmpresa=' . $c_instituicao['Instituicao']['convenio']);
                else:
                    echo $c_instituicao['Instituicao']['convenio'];
                endif;    
                ?>
            </td>
            <td><?php echo $c_instituicao['Instituicao']['virtualMaxPeriodo']; ?></td>
            <td><?php echo $c_instituicao['Instituicao']['virtualEstudantes']; ?></td>
            <td><?php echo $c_instituicao['Instituicao']['virtualSupervisores']; ?></td>
            <td><?php echo $c_instituicao['AreaInstituicao']['area']; ?></td>
            <td><?php echo $c_instituicao['Instituicao']['natureza']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
