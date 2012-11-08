<?php
// pr($supervisores);
?>
<?php
echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

$("#SupervisorPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        window.location="/mycake/Supervisors/index/periodo:"+periodo;
	})

})

', array("inline"=>false)

);
?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Inserir','/Supervisors/add/');
    echo " | ";
    echo $this->Html->link('Buscar','/Supervisors/busca/');
    echo " || ";
    echo $this->Html->link('Repetidos','/Supervisors/repetidos/');
    echo " | ";
    echo $this->Html->link('Sem alunos','/Supervisors/semalunos/');
    ?>
    <br />
<?php else: ?>
    <?php
    echo $this->Html->link('Buscar','/Supervisors/busca/');
    ?>
    <br />
<?php endif; ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Supervisor', array('controller' => 'Instituicao', 'action'=>'index')); ?>
    <?php echo $this->Form->input('periodo', array('type'=>'select', 'label'=>array('text'=>'Período ', 'style'=>'display: inline'), 'options'=> $todosPeriodos, 'default'=>$periodo, 'empty'=>'Selecione período')); ?>
    <?php echo $this->Form->end(); ?>
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
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <th>X</th>
                <th width='10%'><?php echo $this->Paginator->sort('Supervisor.cress', 'CRESS'); ?></th>
            <?php endif; ?>
            <th width='50%'><?php echo $this->Paginator->sort('Supervisor.nome', 'Nome'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualestagiarios', 'Estagiários'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualestudantes', 'Estudantes'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualperiodos', 'Períodos'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualmaxperiodo', 'Último período'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($supervisores as $c_supervisor): ?>
        <tr>
        <?php if (empty($c_supervisor['Supervisor']['id'])): ?>
            <?php $c_supervisor['Supervisor']['id'] = 0; ?>
        <?php endif; ?>
        
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <td>
                <?php echo $this->Html->link('X', '/Supervisors/delete/'. $c_supervisor['Supervisor']['id'], NULL, 'Confirma?'); ?>
                </td>
                <td>
                <?php echo $c_supervisor['Supervisor']['cress']; ?>
                </td>
            <?php endif; ?>

                <td>
                <?php 
                if ($c_supervisor['Supervisor']['nome']):
                    echo $this->Html->link($c_supervisor['Supervisor']['nome'], '/Supervisors/view/' . $c_supervisor['Supervisor']['id']); 
                else:
                    echo "Sem dados";
                endif;    
                ?>
                </td>
                
                <td>
                <?php 
                if ($c_supervisor['Supervisor']['nome']):
                    echo $this->Html->link($c_supervisor['Supervisor']['virtualestagiarios'], '/Estagiarios/index/id_supervisor:' . $c_supervisor['Supervisor']['id']); 
                else:
                    echo $this->Html->link($c_supervisor['Supervisor']['virtualestagiarios'], '/Estagiarios/index/id_supervisor:' . 'IS NULL');
                endif;
                ?>
                </td>
                
                <td>
                <?php 
                if ($c_supervisor['Supervisor']['nome']):
                    echo $this->Html->link($c_supervisor['Supervisor']['virtualestudantes'], '/Estagiarios/index/id_supervisor:' . $c_supervisor['Supervisor']['id']);
                else:
                    echo $this->Html->link($c_supervisor['Supervisor']['virtualestudantes'], '/Estagiarios/index/id_supervisor:' . 'IS NULL');
                endif;                
                ?>
                </td>
                
                <td>
                <?php 
                if ($c_supervisor['Supervisor']['nome']):                
                    echo $this->Html->link($c_supervisor['Supervisor']['virtualperiodos'], '/Estagiarios/index/id_supervisor:' . $c_supervisor['Supervisor']['id']); 
                else:
                    echo $this->Html->link($c_supervisor['Supervisor']['virtualperiodos'], '/Estagiarios/index/id_supervisor:' . 'IS NULL');
                endif;                
                ?>
                </td>
                
                <td>
                <?php echo $c_supervisor['Supervisor']['virtualmaxperiodo']; ?>
                </td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<?php echo $this->Paginator->counter(array(
'format' => 'Página %page% de %pages%, 
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
)); ?>
