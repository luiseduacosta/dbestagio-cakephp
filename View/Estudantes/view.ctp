<h1>Aluno: <?php echo $alunos['Estudante']['nome']; ?></h1>

<table border='1'>
    <tr>
        <td style='text-align:left'>Registro: <?php echo $alunos['Estudante']['registro']; ?></td>
        <td style='text-align:left'>CPF: <?php echo $alunos['Estudante']['cpf']; ?></td>
        <td style='text-align:left'>Cartera de identidade: <?php echo $alunos['Estudante']['identidade']; ?></td>
        <td style='text-align:left'>Orgão: <?php echo $alunos['Estudante']['orgao']; ?></td>
    </tr>
    <tr style='text-align:left'>
        <td style='text-align:left'>Nascimento: <?php echo date('d-m-Y', strtotime($alunos['Estudante']['nascimento'])); ?></td>
        <td style='text-align:left'>Email: <?php echo $alunos['Estudante']['email']; ?></td>
        <td style='text-align:left'>Telefone: <?php echo "(" . $alunos['Estudante']['codigo_telefone'] . ")" . $alunos['Estudante']['telefone']; ?></td>
        <td style='text-align:left'>Celular: <?php echo "(" . $alunos['Estudante']['codigo_celular'] . ")" . $alunos['Estudante']['celular']; ?></td>
    </tr>
    <tr>
        <td style='text-align:left'>Endereço: <?php echo $alunos['Estudante']['endereco']; ?></td>
        <td style='text-align:left'>CEP: <?php echo $alunos['Estudante']['cep']; ?></td>
        <td style='text-align:left'>Bairro: <?php echo $alunos['Estudante']['bairro']; ?></td>
        <td style='text-align:left'>Municipio: <?php echo $alunos['Estudante']['municipio']; ?></td>
    </tr>
</table>

<hr/>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <p>
        <?php echo $this->Html->link('Excluir', '/Estudantes/delete/' . $alunos['Estudante']['id'], null, 'Tem certeza?') . ' | '; ?>
        <?php echo $this->Html->link('Editar', '/Estudantes/edit/' . $alunos['Estudante']['id']); ?>
    </p>

    <hr/>

    <p>
        <?php echo $this->Html->link('Estudantes', array('controller' => 'Estudantes', 'action' => 'index')); ?> |
        <?php echo $this->Html->link('Buscar', array('controller' => 'Estudantes', 'action' => 'busca')); ?>
        <br />
        <?php echo $this->Html->link('Todos os alunos', array('controller' => 'Inscricoes', 'action' => 'index')); ?>
    </p>
<?php endif; ?>

<?php if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero') === $alunos['Estudante']['registro'])): ?>
    <p>
        <?php echo $this->Html->link('Editar', '/Estudantes/edit/' . $alunos['Estudante']['id']); ?>
    </p>
<?php endif; ?>

<hr/>

<?php // pr($inscricoes); ?>

<?php if (isset($inscricoes) && !empty($inscricoes)): ?>
    <table>
        <caption>Inscrições realizadas</caption>
        <?php foreach ($inscricoes as $c_inscricao): ?>
        <?php // pr($c_inscricao) ?>
            <tr>

                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <td><?php echo $this->Html->link('Inscrição', '/Inscricoes/view/' . $c_inscricao['inscricao_id']); ?></td>
                    <td><?php echo $this->Html->link($c_inscricao['instituicao'], '/Inscricoes/index/mural_estagio_id:' . $c_inscricao['id']); ?></td>
                    <td><?php echo $c_inscricao['periodo']; ?></td>
                <?php else: ?>
                    <td><?php echo $this->Html->link('Inscrição', '/Inscricoes/view/' . $c_inscricao['inscricao_id']); ?></td>                    
                    <td><?php echo $this->Html->link($c_inscricao['instituicao'], '/Inscricoes/index/mural_estagio_id:' . $c_inscricao['id']); ?></td>
                    <td><?php echo $c_inscricao['periodo']; ?></td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>

    </table>
<?php else: ?>

    <h1>Sem inscrições para seleção de estágio!</h1>

<?php endif; ?>

<?php // pr($estagios);?>
<?php // die(); ?>

<table border='1'>
    <caption>Estágios cursados</caption>
    <tr>
        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <th>Excluir</th>
            <th>Editar</th>
        <?php endif; ?>

        <th>Período</th>
        <th>Nível</th>
        <th>Turno</th>
        <th>TC</th>
        <th>Instituição</th>
        <th>Supervisor</th>
        <th>Professor</th>
        <th>Área</th>

        <th>Nota</th>
        <th>CH</th>
    </tr>

    <?php foreach ($estagios as $c_aluno_estagio): ?>
        <?php // pr($c_aluno_estagio); ?>
        <?php // die(); ?>
        <tr>

            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <td>
                    <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_aluno_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_aluno_estagio['Estagiario']['id']); ?>
                </td>
            <?php endif; ?>

            <td><?php echo $c_aluno_estagio['Estagiario']['periodo'] ?></td>
            <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['nivel']; ?></td>
            <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['turno']; ?></td>
            <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['tc']; ?></td>
            <td><?php echo $this->Html->link($c_aluno_estagio['Instituicao']['instituicao'], '/Instituicoes/view/' . $c_aluno_estagio['Instituicao']['id']); ?></td>
            <td><?php echo $this->Html->link($c_aluno_estagio['Supervisor']['nome'], '/Supervisors/view/' . $c_aluno_estagio['Supervisor']['id']); ?></td>
            <td><?php echo $this->Html->link($c_aluno_estagio['Professor']['nome'], '/Professors/view/' . $c_aluno_estagio['Professor']['id']); ?></td>
            <td><?php echo $this->Html->link($c_aluno_estagio['Areaestagio']['area'], '/Areaestagios/view/' . $c_aluno_estagio['Areaestagio']['id']); ?></td>
            <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['nota']; ?></td>
            <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['ch']; ?></td>

        </tr>

        <?php if ($c_aluno_estagio['Estagiario']['nivel'] > '4'): ?>
            <tr>
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <td>
                        <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_aluno_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_aluno_estagio['Estagiario']['id']); ?>
                    </td>
                <?php endif; ?>

                <td><?php echo $c_aluno_estagio['Estagiario']['periodo'] ?></td>
                <td style='text-align:center'><?php echo "Não obrigatório"; ?></td>
                <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['turno']; ?></td>
                <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['tc']; ?></td>
                <td><?php echo $this->Html->link($c_aluno_estagio['Instituicao']['instituicao'], '/Instituicoes/view/' . $c_aluno_estagio['Instituicao']['id']); ?></td>
                <td><?php echo $this->Html->link($c_aluno_estagio['Supervisor']['nome'], '/Supervisors/view/' . $c_aluno_estagio['Supervisor']['id']); ?></td>
                <td><?php echo $this->Html->link($c_aluno_estagio['Professor']['nome'], '/Professors/view/' . $c_aluno_estagio['Professor']['id']); ?></td>
                <td><?php echo $this->Html->link($c_aluno_estagio['Areaestagio']['area'], '/Areaestagios/view/' . $c_aluno_estagio['Areaestagio']['id']); ?></td>
                <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['nota']; ?></td>
                <td style='text-align:center'><?php echo $c_aluno_estagio['Estagiario']['ch']; ?></td>

            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

</table>
