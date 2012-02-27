<div align="center">
<?php echo $html->link('Retroceder', array('action'=>'view', $registro_prev)) . " "; ?> |
<?php echo $html->link('Avançar'   , array('action'=>'view', $registro_next)); ?>
</div>

<table>
    <tr>
        <td width="15%">Instituição</td>

        <td width="85%">
        <?php echo $html->link($instituicao['Instituicao']['instituicao'], '/Estagiarios/index/id_instituicao:' . $instituicao['Instituicao']['id']); ?>
        </td>
    </tr>

    <tr>
        <td>Internet</td>

        <td>
        <?php echo $html->link($instituicao['Instituicao']['url'], $instituicao['Instituicao']['url']); ?>
        </td>
    </tr>

    <tr>
        <td>Convênio com a UFRJ</td>

        <td>
        <?php
        if (!empty($instituicao['Instituicao']['convenio'])) {
            echo $html->link($instituicao['Instituicao']['convenio'], "http://www.pr1.ufrj.br/estagios/info.php?codEmpresa=" . $instituicao['Instituicao']['convenio']);
        } else {
            echo "Sem dados";
        }
        ?>
        </td>
    </tr>

    <tr>
        <td>Seguro</td>

        <td>
        <?php echo $instituicao['Instituicao']['seguro']; ?>
        </td>
    </tr>

    <tr>
        <td>Área da instituição</td>

        <td>
        <?php echo $instituicao['Area']['area']; ?>
        </td>
    </tr>

    <tr>
        <td>Natureza</td>

        <td>
        <?php echo $instituicao['Instituicao']['natureza']; ?>
        </td>
    </tr>

    <tr>
        <td>Endereço</td>

        <td>
        <?php echo $instituicao['Instituicao']['endereco']; ?>
        </td>
    </tr>

    <tr>
        <td>CEP</td>

        <td>
        <?php echo $instituicao['Instituicao']['cep']; ?>
        </td>
    </tr>

    <tr>
        <td>Bairro</td>

        <td>
        <?php echo $instituicao['Instituicao']['bairro']; ?>
        </td>
    </tr>

    <tr>
        <td>Município</td>

        <td>
        <?php echo $instituicao['Instituicao']['municipio']; ?>
        </td>
    </tr>

    <tr>
        <td>Telefone</td>

        <td>
        <?php echo $instituicao['Instituicao']['telefone']; ?>
        </td>
    </tr>

    <tr>
        <td>Fax</td>

        <td>
        <?php echo $instituicao['Instituicao']['fax']; ?>
        </td>
    </tr>

    <tr>
        <td>Benefícios</td>

        <td>
        <?php echo $instituicao['Instituicao']['beneficio']; ?>
        </td>
    </tr>

    <tr>
        <td>Final de semana</td>

        <td>
        <?php echo $instituicao['Instituicao']['fim_de_semana']; ?>
        </td>
    </tr>

    <tr>
        <td>Observações</td>

        <td>
        <?php echo $instituicao['Instituicao']['observacoes']; ?>
        </td>
    </tr>

</table>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
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
<?php else: ?>
    <?php
    echo $html->link('Editar','/Instituicaos/edit/' . $instituicao['Instituicao']['id']);
    echo " | ";
    echo $html->link('Buscar','/Instituicaos/busca/');
    echo " | ";
    echo $html->link('Listar','/Instituicaos/index/');
    ?>
<?php endif; ?>

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
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <th>
            	Ação
            </th>
            <?php endif; ?>
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
        
        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <td>
                <?php 
                echo $html->link('Excluir', '/Instituicaos/deleteassociacao/' . $c_supervisor['id_superinst'], NULL, 'Tem certeza?');
                ?>
            </td>
        <?php endif; ?>
        
    </tr>
    </tbody>
    <?php endforeach; ?>
</table>

<?php endif; ?>

<hr />

<?php if ($this->Session->read('categoria') != 'estudante'): ?>

<h1>Inserir supervisor</h1>

<?php

echo $form->create('Instituicao', array('controller'=>'Instituicaos', 'action'=>'addassociacao'));
echo $form->input('InstSuper.id_instituicao', array('type'=>'hidden', 'value'=>$instituicao['Instituicao']['id']));
echo $form->input('InstSuper.id_supervisor', array('label'=>'Supervisor', 'options'=>$supervisores, 'default'=>0));
echo $form->end('Confirma');

?>

<?php endif; ?>
