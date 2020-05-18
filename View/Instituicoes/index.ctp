<?php

// pr($instituicoes);

?>

<?php
echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;
var base_url = window.location.pathname.split("/");

$("#InstituicaoPeriodo").change(function() {
	var periodo = $(this).val();
	var limite = $("#LimiteLimite").val();
        /* alert(periodo +  " " + limite); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/Instituicoes/index/periodo:" +periodo+ "/limite:" +limite;
        } else {
            window.location="/Instituicoes/index/periodo:" +periodo+ "/limite:" +limite;
        }

})

})

', array("inline"=>false)

);
?>

<?php echo $this->element('submenu_instituicoes'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>

    <?php echo $this->Form->create('Instituicao', array('controller' => 'Instituicao', 'url'=>'index')); ?>
    <?php echo $this->Form->input('periodo', array('type'=>'select', 'label'=>array('text'=>'Período ', 'style'=>'display: inline'), 'options'=> $todosPeriodos, 'default'=>$periodo, 'empty'=>'Selecione')); ?>
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
            <th>
                <?php echo $this->Paginator->sort('Instituicao.id', 'Id'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.expira', 'Expira'); ?>
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
                <?php echo $this->Paginator->sort('Areainstituicao.area', 'Área'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.natureza', 'Natureza'); ?>
            </th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($instituicoes as $c_instituicao): ?>
        <tr>
            <td><?php echo $this->Html->link($c_instituicao['Instituicao']['id'], '/Instituicoes/view/' . $c_instituicao['Instituicao']['id']); ?></td>
            <td><?php echo $this->Html->link($c_instituicao['Instituicao']['instituicao'], '/Instituicoes/view/' . $c_instituicao['Instituicao']['id']); ?></td>
            <td><?php
if ($c_instituicao['Instituicao']['expira']):
echo date('d-m-Y', strtotime($c_instituicao['Instituicao']['expira']));
endif;
?></td>
            <td><?php echo $c_instituicao['Instituicao']['virtualMaxPeriodo']; ?></td>
            <td><?php echo $c_instituicao['Instituicao']['virtualEstudantes']; ?></td>
            <td><?php echo $c_instituicao['Instituicao']['virtualSupervisores']; ?></td>
            <td><?php echo $c_instituicao['Areainstituicao']['area']; ?></td>
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
