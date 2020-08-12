<?php // pr($supervisor);      ?>
<?php // pr($estagiarios);      ?>
<?php // die();      ?>

<?= $this->element('submenu_supervisores') ?>

<div class='container'>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active btn-light" data-toggle="pill" href="#dados_supervisor">Supervisor</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-light" data-toggle="pill" href="#dados_instituicao">Instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-light" data-toggle="pill" href="#dados_adicionarinstituicao">Adicionar instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-light" data-toggle="pill" href="#dados_estagiarios">Estagiários</a>
        </li>
    </ul>
</div>

<div class='tab-content'>
    <div class="tab-pane container active" id="dados_supervisor">
        <?php if (($this->Session->read('categoria') === 'supervisor') and ($this->Session->read('numero') === $supervisor[(array_key_first($supervisor))]['Supervisor']['cress'])): ?>
            <?php echo $this->Html->link('Meus estudantes', '/Estagiarios/index/supervisor_id:' . $supervisor[(array_key_first($supervisor))]['Supervisor']['id'] . '/periodo:0'); ?>
        <?php elseif ($this->Session->read('categoria') === 'administrador'): ?>
            <?php echo $this->Html->link('Meus estudantes', '/Estagiarios/index/supervisor_id:' . $supervisor[(array_key_first($supervisor))]['Supervisor']['id'] . '/periodo:0'); ?>
        <?php endif; ?>

        <?php // echo (count($supervisor)); ?>
        <?php if (isset($supervisor)): ?>
            <?php // pr($supervisor); ?>
            <?php // die(); ?>
            <div class='row justify-content-center'>
                <div class='col-auto'>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive">
                            <caption style='caption-side: top;'>Dados do/a supervisor/a</caption>
                            <tbody>
                                <?php foreach ($supervisor as $c_supervisor): ?>
                                    <?php // pr($c_supervisor); ?>
                                    <tr>
                                        <td>
                                            CRESS <?php echo $c_supervisor['Supervisor']['regiao']; ?> Região
                                        </td>

                                        <td>
                                            <?php echo $c_supervisor['Supervisor']['cress']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Nome</td>
                                        <td>
                                            <?php echo $this->Html->link($c_supervisor['Supervisor']['nome'], '/Estagiarios/index/supervisor_id:' . $c_supervisor['Supervisor']['id']); ?>
                                        </td>
                                    </tr>

                                    <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                                        <tr>
                                            <td>CPF</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['cpf']; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <tr>
                                        <td>Telefone</td>
                                        <td>
                                            <?php echo "( " . $c_supervisor['Supervisor']['codigo_tel'] . ") " . $c_supervisor['Supervisor']['telefone']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Celular</td>
                                        <td>
                                            <?php echo "( " . $c_supervisor['Supervisor']['codigo_cel'] . ") " . $c_supervisor['Supervisor']['celular']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Email</td>
                                        <td>
                                            <?php echo $c_supervisor['Supervisor']['email']; ?>
                                        </td>
                                    </tr>

                                    <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                                        <tr>
                                            <td>Endereço</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['endereco']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>CEP</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['cep']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Bairro</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['bairro']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Município</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['municipio']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Escola de formação</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['escola']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Ano da formatura</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['ano_formatura']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Outros estudos</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['outros_estudos']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Área dos outros estudos</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['area_curso']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Ano de finalização dos outros estudos</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['ano_curso']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Turma do Curso supervisores</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['curso_turma']; ?>
                                                <?php echo " Número de inscrição: "; ?>
                                                <?php echo $c_supervisor['Supervisor']['num_inscricao']; ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td>Observações</td>
                                            <td>
                                                <?php echo $c_supervisor['Supervisor']['observacoes']; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <nav class='nav nav-tabs nav-justified'>
                    <?php
                    echo $this->Html->link('Excluir', '/Supervisores/delete/' . $c_supervisor['Supervisor']['id'], ['class' => 'nav-link'], 'Tem certeza?');
                    echo $this->Html->link('Editar', '/Supervisores/edit/' . $c_supervisor['Supervisor']['id'], ['class' => 'nav-link']);
                    echo $this->Html->link('Inserir', '/Supervisores/add/', ['class' => 'nav-link']);
                    echo $this->Html->link('Buscar', '/Supervisores/busca/', ['class' => 'nav-link']);
                    echo $this->Html->link('Listar', '/Supervisores/index/', ['class' => 'nav-link']);
                    ?>
                </nav>
            <?php endif; ?>

            <?php if (($this->Session->read('categoria') === 'supervisor') || ($this->Session->read('categoria') === 'professor')): ?>
                <nav class='nav nav-tabs nav-justified'>
                    <?php
                    echo $this->Html->link('Editar', '/Supervisores/edit/' . $c_supervisor['Supervisor']['id'], ['class' => 'nav-link']);
                    echo $this->Html->link('Inserir', '/Supervisores/add/', ['class' => 'nav-link']);
                    echo $this->Html->link('Buscar', '/Supervisores/busca/', ['class' => 'nav-link']);
                    echo $this->Html->link('Listar', '/Supervisores/index/', ['class' => 'nav-link']);
                    ?>
                </nav>
            <?php endif; ?>

            <?php if ($this->Session->read('categoria') === 'estudante'): ?>
                <nav class='nav nav-tabs nav-justified'>
                    <?php
                    echo $this->Html->link('Editar', '/Supervisores/edit/' . $c_supervisor['Supervisor']['id'], ['class' => 'nav-link']);
                    echo $this->Html->link('Buscar', '/Supervisores/busca/', ['class' => 'nav-link']);
                    echo $this->Html->link('Listar', '/Supervisores/index/', ['class' => 'nav-link']);
                    ?>
                </nav>
            <?php endif; ?>

        <?php endif; ?>
    </div>

    <div class="tab-pane container fade" id="dados_instituicao">

        <?php
        foreach ($supervisor as $c_supervisor) {
            // pr($c_supervisor);
            // die();
            if ($c_supervisor['Instituicaoestagio']) {

                $i = 0;
                foreach ($c_supervisor['Instituicaoestagio'] as $cada_instituicao) {

                    $c_instituicao[$i]['instituicao'] = $cada_instituicao['instituicao'];
                    $c_instituicao[$i]['id'] = $cada_instituicao['id'];
                    $c_instituicao[$i]['id_superinst'] = $cada_instituicao['InstituicaoestagioSupervisor']['id'];
                    $i++;
                }
            }
        }
        ?>

        <?php if (isset($c_instituicao)): ?>
            <?php sort($c_instituicao); ?>
            <?php // pr($c_instituicao); ?>
            <div class='table-responsive'>
                <table class="table table-striped table-hover table-responsive">
                    <caption style='caption-side: top;'>Instituições</caption>
                    <thead class="thead-light">
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
                                    <?php echo $this->Html->link($instituicao['instituicao'], '/Instituicaoestagios/view/' . $instituicao['id']); ?>
                                </td>
                                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                    <td>
                                        <?php echo $this->Html->link('Excluir', '/Supervisores/deleteassociacao/' . $instituicao['id_superinst'], NULL, 'Tem certeza?'); ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <p>Sem instituição cadastrada</p>
        <?php endif; ?>

    </div>

    <div class="tab-pane container fade" id="dados_adicionarinstituicao">

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>
            <div class="jumbotron">
                <fieldset>
                    <h5 class="text-center">Inserir instituição</h5>

                    <?= $this->Form->create('Supervisor', array('controller' => 'Supervisores', 'url' => 'addinstituicao')); ?>
                    <?= $this->Form->input('InstituicaoestagioSupervisor.instituicaoestagio_id', array('label' => 'Instituição: ', 'options' => $instituicoes, 'default' => 0, 'empty' => ['0' => 'Selecione'], 'class' => 'form-control')); ?>
                    <?= $this->Form->input('InstituicaoestagioSupervisor.supervisor_id', array('type' => 'hidden', 'value' => $c_supervisor['Supervisor']['id'])); ?>
                    <br>
                    <?= $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
                    <?= $this->Form->end(); ?>

                </fieldset>
            </div>
        <?php endif; ?>
    </div>

    <div class="tab-pane container fade" id="dados_estagiarios">

        <div class='row justify-content-center'>
            <div class='col-auto'>

                <div class="table-responsive">

                    <table class="table table-striped table-hover table-responsive">
                        <caption style='caption-side: top;'>Supervisor</caption>
                        <thead class="thead-light">
                            <tr>
                                <th>Estudante</th>
                                <th>Nível</th>
                                <th>Período</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($supervisor as $c_supervisor): ?>
                                <?php // pr($c_supervisor) ?>
                                <tr>
                                    <td><?= $c_supervisor['Supervisor']['cress']; ?></td>
                                    <td><?= $this->Html->link($c_supervisor['Supervisor']['nome'], '/Supervisores/view/' . $c_supervisor['Supervisor']['id']); ?></td>
                                    <?php if (!empty($c_supervisor['Estagiario'])): ?>
                                        <td><?= count($c_supervisor['Estagiario']); ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (!empty($estagiarios)): ?>

                                <?php foreach ($estagiarios as $c_estagiario): ?>
                                    <?php // pr($c_estagiario); ?>
                                    <tr>
                                        <td>
                                            <?= $this->Html->link($c_estagiario['nome'], '/Estudantes/view/registro:' . $c_estagiario['registro']) ?>
                                        </td>
                                        <td style="text-align: center">
                                            <?= $c_estagiario['nivel'] ?>
                                        </td>
                                        <td>
                                            <?= $c_estagiario['periodo'] ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            <?php else: ?>
                            <p>Sem estagiários</p>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>