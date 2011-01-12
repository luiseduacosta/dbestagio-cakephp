<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div align="center">
<?php echo $html->link('Retroceder', array('action'=>'view', $registro_prev)) . " "; ?> |
<?php echo $html->link('Avançar'   , array('action'=>'view', $registro_next)); ?>
</div>

<table>
    <tr>
        <td>
        <?php echo $html->link($instituicao['Instituicao']['instituicao'], '/Estagiarios/index/id_instituicao:' . $instituicao['Instituicao']['id']); ?>
        </td>
    </tr>

    <tr>
        <td>
        <?php echo $instituicao['Instituicao']['endereco']; ?>
        </td>
    </tr>

    <tr>
        <td>
        <?php echo $instituicao['Instituicao']['cep']; ?>
        </td>
    </tr>

    <tr>
        <td>
        <?php echo $instituicao['Instituicao']['bairro']; ?>
        </td>
    </tr>

    <tr>
        <td>
        <?php echo $instituicao['Instituicao']['municipio']; ?>
        </td>
    </tr>

</table>

<?php
echo $html->link('Excluir','/Instituicaos/delete/' . $instituicao['Instituicao']['id'], NULL, 'Tem certeza?');
echo " | ";
echo $html->link('Editar','/Instituicaos/edit/' . $instituicao['Instituicao']['id']);
echo " | ";
echo $html->link('Inserir','/Instituicaos/add/');
echo " | ";
echo $html->link('Buscar','/Instituicaos/busca/');
echo " | ";
echo $html->link('Listar','/Instituicaos/index/');
?>

<?php

// pr($instituicao['Supervisor']);

if ($instituicao['Supervisor']) {
	$i = 0;
	foreach ($instituicao['Supervisor'] as $c_supervisor) {

    	$cada_supervisor[$i]['nome'] = $c_supervisor['nome'];
    	$cada_supervisor[$i]['id'] = $c_supervisor['id'];
    	$cada_supervisor[$i]['cress'] = $c_supervisor['cress'];
		$cada_supervisor[$i]['id_superinst'] = $c_supervisor['InstSuper']['id'];
    	$i++;
    
    }
	sort($cada_supervisor);
}

?>

<?php if (isset($cada_supervisor)): ?>

<br />
<hr />

<table>
    <thead>
        <tr>
            <th>
                CRESS
            </th>
            <th>
                Nome
            </th>
            <th>
            	Ação
            </th>
        </tr>
    </thead>
    <?php foreach ($cada_supervisor as $c_supervisor): ?>
    <tbody>
    <tr>
        <td>
            <?php echo $c_supervisor['cress']; ?>
        </td>
        <td>
            <?php
            echo $html->link($c_supervisor['nome'],'/Supervisors/view/'. $c_supervisor['id']);
            ?>
        </td>
        <td>
        	<?php 
        	echo $html->link('Excluir', '/Instituicaos/deleteassociacao/' . $c_supervisor['id_superinst'], NULL, 'Tem certeza?');
			?>
        </td>
        
    </tr>
    </tbody>
    <?php endforeach; ?>
</table>

<?php endif; ?>

<hr />

<h1>Inserir supervisor</h1>

<?php

echo $form->create('Instituicao', array('controller'=>'Instituicaos', 'action'=>'addassociacao'));
echo $form->input('InstSuper.id_instituicao', array('type'=>'hidden', 'value'=>$instituicao['Instituicao']['id']));
echo $form->input('InstSuper.id_supervisor', array('label'=>'Supervisor', 'options'=>$supervisores, 'default'=>0));
echo $form->end('Confirma');

?>
