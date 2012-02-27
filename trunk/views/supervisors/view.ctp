<?php // pr($supervisor); ?>

<?php if (($this->Session->read('categoria') === 'supervisor') and ($this->Session->read('numero') === $supervisor['Supervisor']['cress'])): ?>
    <?php echo $html->link('Meus estudantes', '/estagiarios/index/id_supervisor:' . $supervisor['Supervisor']['id'] . '/periodo:0'); ?>
<?php endif; ?>

<div align="center">
<?php echo $html->link('Retroceder', array('action'=>'view', $registro_prev)) . " "; ?> |
<?php echo $html->link('Avançar'   , array('action'=>'view', $registro_next)); ?>
</div>

<table>
    <tbody>
        <tr>
            <td width="15%">
            CRESS <?php echo $supervisor['Supervisor']['regiao']; ?> Região
            </td>

            <td width="85%">
            <?php echo $supervisor['Supervisor']['cress']; ?>
            </td>
        </tr>

        <tr>
            <td>Nome</td>
            <td>
            <?php echo $html->link($supervisor['Supervisor']['nome'], '/Estagiarios/index/id_supervisor:' . $supervisor['Supervisor']['id']); ?>
            </td>
        </tr>

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>
        <tr>
            <td>CPF</td>
            <td>
            <?php echo $supervisor['Supervisor']['cpf']; ?>
            </td>
        </tr>
        <?php endif; ?>
        
        <tr>
            <td>Telefone</td>
            <td>
            <?php echo "( " . $supervisor['Supervisor']['codigo_tel'] . ") " . $supervisor['Supervisor']['telefone']; ?>
            </td>
        </tr>

        <tr>
            <td>Celular</td>
            <td>
            <?php echo "( " . $supervisor['Supervisor']['codigo_cel'] . ") " . $supervisor['Supervisor']['celular']; ?>
            </td>
        </tr>

        <tr>
            <td>Email</td>
            <td>
            <?php echo $supervisor['Supervisor']['email']; ?>
            </td>
        </tr>

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>
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

            <tr>
                <td>Escola de formação</td>
                <td>
                <?php echo $supervisor['Supervisor']['escola']; ?>
                </td>
            </tr>

            <tr>
                <td>Ano da formatura</td>
                <td>
                <?php echo $supervisor['Supervisor']['ano_formatura']; ?>
                </td>
            </tr>

            <tr>
                <td>Outros estudos</td>
                <td>
                <?php echo $supervisor['Supervisor']['outros_estudos']; ?>
                </td>
            </tr>

            <tr>
                <td>Área dos outros estudos</td>
                <td>
                <?php echo $supervisor['Supervisor']['area_curso']; ?>
                </td>
            </tr>

            <tr>
                <td>Ano de finalização dos outros estudos</td>
                <td>
                <?php echo $supervisor['Supervisor']['ano_curso']; ?>
                </td>
            </tr>

            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <tr>
                <td>Turma do Curso supervisores</td>
                <td>
                <?php echo $supervisor['Supervisor']['curso_turma']; ?>
                <?php echo " Número de inscrição: "; ?>
                <?php echo $supervisor['Supervisor']['num_inscricao']; ?>
                </td>

            </tr>
            <?php endif; ?>

            <tr>
                <td>Observações</td>
                <td>
                <?php echo $supervisor['Supervisor']['observacoes']; ?>
                </td>
            </tr>
        <?php endif; ?>

    </tbody>
</table>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
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
<?php endif; ?>

<?php if (($this->Session->read('categoria') === 'supervisor') || ($this->Session->read('categoria') === 'professor')): ?>
    <?php
    echo $html->link('Editar', '/Supervisors/edit/' . $supervisor['Supervisor']['id']);
    echo " | ";
    echo $html->link('Inserir', '/Supervisors/add/');
    echo " | ";
    echo $html->link('Buscar', '/Supervisors/busca/');
    echo " | ";
    echo $html->link('Listar', '/Supervisors/index/');
    ?>
<?php endif; ?>

<?php if ($this->Session->read('categoria') === 'estudante'): ?>
    <?php
    echo $html->link('Editar', '/Supervisors/edit/' . $supervisor['Supervisor']['id']);
    echo " | ";
    echo $html->link('Buscar', '/Supervisors/busca/');
    echo " | ";
    echo $html->link('Listar', '/Supervisors/index/');
    ?>
<?php endif; ?>

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
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <th>
            	Ação
            </th>
            <?php endif; ?>   
        </tr>
    </thead>
    <tbody>
        <?php foreach ($c_instituicao as $instituicao): ?>
        <tr>
            <td>
                <?php echo $html->link($instituicao['instituicao'], '/Instituicaos/view/' . $instituicao['id']); ?>
            </td>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <td>
                <?php echo $html->link('Excluir', '/Supervisors/deleteassociacao/' . $instituicao['id_superinst'], NULL, 'Tem certeza?'); ?>
                </td>
            <?php endif; ?>   
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<hr/>

<?php if ($this->Session->read('categoria') != 'estudante'): ?>

<h1>Inserir instituição</h1>

<?php

echo $form->create('Supervisor', array('controller'=>'Supervisors', 'action'=>'addinstituicao'));
echo $form->input('InstSuper.id_instituicao', array('label'=>'Instituição', 'options'=>$instituicoes, 'default'=>0));
echo $form->input('InstSuper.id_supervisor', array('type'=>'hidden', 'value'=>$supervisor['Supervisor']['id']));
echo $form->end('Confirma');

?>

<?php endif; ?>

