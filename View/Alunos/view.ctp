<?php
// pr($alunos);
// pr($estagios);
// pr($c_estagios);
// pr($nao_obrigatorio);
?>

<?= $this->element('submenu_alunos'); ?>
<br>
<div class="container">
    <h5><?php echo $alunos['nome']; ?></h5>
</div>
<br>
<?php
if (is_null($alunos['nascimento'])) {
    $nascimento = 'Sem dados';
} elseif ($alunos['nascimento'] == 0) {
    $nascimento = 'Sem informação';
} else {
    $nascimento = date('d-m-Y', strtotime($alunos['nascimento']));
}
?>
<div class='tab-content'>
    <div class="tab-pane container active" id="dados-estudante">
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <td style='text-align:left'>Registro: <?php echo $alunos['registro']; ?></td>
                <td style='text-align:left'>CPF: <?php echo $alunos['cpf']; ?></td>
                <td style='text-align:left'>Carteira de identidade: <?php echo $alunos['identidade']; ?></td>
                <td style='text-align:left'>Orgão: <?php echo $alunos['orgao']; ?></td>
            </tr>
            <tr>
                <td style='text-align:left'>Nascimento: <?php echo $nascimento; ?></td>
                <td style='text-align:left'>Email: <?php echo $alunos['email']; ?></td>
                <td style='text-align:left'>Telefone: <?php echo "(" . $alunos['codigo_telefone'] . ")" . $alunos['telefone']; ?></td>
                <td style='text-align:left'>Celular: <?php echo "(" . $alunos['codigo_celular'] . ")" . $alunos['celular']; ?></td>
            </tr>
            <tr>
                <td style='text-align:left'>Endereço: <?php echo $alunos['endereco']; ?></td>
                <td style='text-align:left'>Bairro: <?php echo $alunos['bairro']; ?></td>
                <td style='text-align:left'>Municipio: <?php echo $alunos['municipio']; ?>
                <td style='text-align:left'>CEP: <?php echo $alunos['cep']; ?></td>
            </tr>
        </table>

        <div class="nav nav-tabs" id="menu-interior">
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <?php echo $this->Html->link('Excluir', '/Alunos/delete/' . $alunos['id'], ['class' => 'nav-item nav-link', 'Tem certeza?']); ?>
            <?php endif; ?>

            <?php if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero') === $alunos['registro'])): ?>
                <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $alunos['id'], ['class' => 'nav-item nav-link']); ?>
            <?php elseif ($this->Session->read('categoria') === 'administrador'): ?>
                <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $alunos['id'], ['class' => 'nav-item nav-link']); ?>
            <?php endif; ?>
        </div>
    </div>

    <div align="center">
        <h5>Estágios cursados</h5>
    </div>

    <div class="tab-pane container fade" id="tabela-estagios"></div>
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
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
        </thead>
        <?php foreach ($c_estagios as $aluno_estagio): ?>
            <tbody>
                <tr>

                    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                        <td>
                            <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $aluno_estagio['id']); ?>
                        </td>
                    <?php endif; ?>

                    <td><?php echo $aluno_estagio['periodo'] ?></td>
                    <td style='text-align:center'><?php echo $aluno_estagio['nivel']; ?></td>
                    <td style='text-align:center'><?php echo $aluno_estagio['turno']; ?></td>
                    <td style='text-align:center'><?php echo $aluno_estagio['tc']; ?></td>
                    <td><?php echo $this->Html->link($aluno_estagio['instituicao'], '/Instituicoes/view/' . $aluno_estagio['instituicao_id']); ?></td>
                    <td><?php echo $this->Html->link($aluno_estagio['supervisor'], '/Supervisores/view/' . $aluno_estagio['supervisor_id']); ?></td>
                    <td><?php echo $this->Html->link($aluno_estagio['professor'], '/Professores/view/' . $aluno_estagio['docente_id']); ?></td>
                    <td><?php echo $this->Html->link($aluno_estagio['areaestagio'], '/Areaestagios/view/' . $aluno_estagio['areaestagio_id']); ?></td>
                    <td style='text-align:center'><?php echo $aluno_estagio['nota']; ?></td>
                    <td style='text-align:center'><?php echo $aluno_estagio['ch']; ?></td>

                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="12"><h5>Estágios não obrigatórios</h5></td>
            </tr>

            <?php if (isset($nao_obrigatorio) && !(empty($nao_obrigatorio))): ?>
                <?php foreach ($nao_obrigatorio as $aluno_nao_estagio): ?>
                    <tr>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <td>
                                <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $aluno_nao_estagio['id']); ?>
                            </td>
                        <?php endif; ?>

                        <td><?php echo $aluno_nao_estagio['periodo'] ?></td>
                        <td style='text-align:center'><?php echo "Não obrigatório"; ?></td>
                        <td style='text-align:center'><?php echo $aluno_nao_estagio['turno']; ?></td>
                        <td style='text-align:center'><?php echo $aluno_nao_estagio['tc']; ?></td>
                        <td><?php echo $this->Html->link($aluno_nao_estagio['instituicao'], '/Instituicoes/view/' . $aluno_nao_estagio['instituicao_id']); ?></td>
                        <td><?php echo $this->Html->link($aluno_nao_estagio['supervisor'], '/Supervisors/view/' . $aluno_nao_estagio['supervisor_id']); ?></td>
                        <td><?php echo $this->Html->link($aluno_nao_estagio['professor'], '/Professors/view/' . $aluno_estagio['docente_id']); ?></td>
                        <td><?php echo $this->Html->link($aluno_nao_estagio['areaestagio'], '/Areaestagios/view/' . $aluno_nao_estagio['areaestagio_id']); ?></td>
                        <td style='text-align:center'><?php echo $aluno_nao_estagio['nota']; ?></td>
                        <td style='text-align:center'><?php echo $aluno_nao_estagio['ch']; ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>

<div class="nav nav-tabs" id="menu-inferior">
    <?php echo $this->Html->link('Listar', ['controller' => 'Estagiarios', 'action' => 'index'], ['class' => 'nav-item nav-link']); ?>
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <?php echo $this->Html->link("Inserir estágio", ['controller' => 'Estagiarios', 'action' => 'add', $alunos['id']], ['class' => 'nav-item nav-link']); ?>
    <?php endif; ?>
</div>