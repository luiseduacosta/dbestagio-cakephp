<?php // pr($supervisor); ?>

<div align="center">

<?php echo $html->link('Retroceder', array('action'=>'view', $registro_prev)) . " "; ?> |
<?php echo $html->link('Avançar'   , array('action'=>'view', $registro_next)); ?>

</div>

<table>
    <thead>
        <tr>
            <th width='20%'>
            Item
            </th>
            <th width='80%'>
            Valor
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
            CRESS
            </td>

            <td>
            <?php echo $supervisor['Supervisor']['cress']; ?>
            </td>
        </tr>

        <tr>
            <td>Nome</td>
            <td>
            <?php echo $html->link($supervisor['Supervisor']['nome'], '/Estagiarios/index/id_supervisor:' . $supervisor['Supervisor']['id']); ?>
            </td>
        </tr>
        
        <tr>
            <td>CPF</td>
            <td>
            <?php echo $supervisor['Supervisor']['cpf']; ?>
            </td>
        </tr>
        
        <tr>
            <td>Código</td>
            <td>
            <?php echo $supervisor['Supervisor']['codigo_tel']; ?>
            </td>
        </tr>
        
        <tr>
            <td>Telefone</td>
            <td>
            <?php echo $supervisor['Supervisor']['telefone']; ?>
            </td>
        </tr>

        <tr>
            <td>Código</td>
            <td>
            <?php echo $supervisor['Supervisor']['codigo_cel']; ?>
            </td>
        </tr>

        <tr>
            <td>Celular</td>
            <td>
            <?php echo $supervisor['Supervisor']['celular']; ?>
            </td>
        </tr>

        <tr>
            <td>Email</td>
            <td>
            <?php echo $supervisor['Supervisor']['email']; ?>
            </td>
        </tr>

        <tr>
            <td>Endereço</td>
            <td>
            <?php echo $supervisor['Supervisor']['endereco']; ?>
            </td>
        </tr>

        <tr>
            <td>CEP</td>
            <td>
            <?php echo $supervisor['Supervisor']['cep']; ?>
            </td>
        </tr>

        <tr>
            <td>Bairro</td>
            <td>
            <?php echo $supervisor['Supervisor']['bairro']; ?>
            </td>
        </tr>

        <tr>
            <td>Município</td>
            <td>
            <?php echo $supervisor['Supervisor']['municipio']; ?>
            </td>
        </tr>

    </tbody>
</table>

<?php

echo $html->link('Excluir', '/Supervisors/delete/' . $supervisor['Supervisor']['id'], NULL, 'Tem certeza?');
echo " | ";
echo $html->link('Editar', '/Supervisors/edit/' . $supervisor['Supervisor']['id']);
echo " | ";
echo $html->link('Inserir', '/Supervisors/add/');
echo " | ";
echo $html->link('Buscar', '/Supervisors/busca/');
echo " | ";
echo $html->link('Listar', '/Supervisors/index/');

?>


<?php

// pr($supervisor['Instituicao']);

if ($supervisor['Instituicao']) {

    $i = 0;
    foreach ($supervisor['Instituicao'] as $cada_instituicao) {

        $c_instituicao[$i]['instituicao'] = $cada_instituicao['instituicao'];
        $c_instituicao[$i]['id'] = $cada_instituicao['id'];
		$c_instituicao[$i]['id_superinst'] = $cada_instituicao['InstSuper']['id'];
        $i++;

    }

    sort($c_instituicao);

}

// pr($c_instituicao);

?>

<?php if (isset($c_instituicao)): ?>

<table>
    <thead>
        <tr>
            <th>
                Instituição
            </th>
            <th>
            	Ação
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($c_instituicao as $instituicao): ?>
        <tr>
            <td>
                <?php echo $html->link($instituicao['instituicao'], '/Instituicaos/view/' . $instituicao['id']); ?>
            </td>
			<td>
				<?php echo $html->link('Excluir', '/Supervisors/deleteassociacao/' . $instituicao['id_superinst'], NULL, 'Tem certeza?'); ?>
			</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<hr/>

<h1>Inserir instituição</h1>

<?php

echo $form->create('Supervisor', array('controller'=>'Supervisors', 'action'=>'addinstituicao'));
echo $form->input('InstSuper.id_instituicao', array('options'=>$instituicoes, 'default'=>0));
echo $form->input('InstSuper.id_supervisor', array('type'=>'hidden', 'value'=>$supervisor['Supervisor']['id']));
echo $form->end('Confirma');

?>
