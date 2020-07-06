<?php echo $this->Html->link('Estagiarios', '/Estagiarios/index/' . $estagio['Estagiario']['periodo']); ?>

<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#dados_estagio">Estágio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#estagio_historico">Histórico</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#dados_pessoais">Dados pessoais</a>
    </li>
</ul>


<h5>Estágiario: <?php echo $estagio['Estudante']['nome']; ?></h5>
<div class='tab-content'>
    <div class="tab-pane container active" id="dados_estagio">
        <table class ='table table-responsive'>
            <tbody>

                <tr>
                    <td>Registro</td>
                    <td><?php echo $estagio['Estagiario']['registro']; ?></td>
                </tr>

                <tr>
                    <td>Ajuste curricular 2020</td>
                    <td><?php echo $estagio['Estagiario']['ajustecurricular2020']; ?></td>
                </tr>

                <tr>
                    <td>Período</td>
                    <td><?php echo $estagio['Estagiario']['periodo']; ?></td>
                </tr>

                <tr>
                    <td>Nível</td>
                    <td><?php echo $estagio['Estagiario']['nivel']; ?></td>
                </tr>

                <tr>
                    <td>Turno</td>
                    <td>
                        <?php
                        switch ($estagio['Estagiario']['turno']) {
                            case 'D': echo 'Diurno';
                                break;
                            case 'N': echo 'Noturno';
                                break;
                            case 'I': echo 'Indeterminado';
                                break;
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Solicitação do TC</td>
                    <td><?php echo date('d-m-Y', strtotime($estagio['Estagiario']['tc_solicitacao'])); ?></td>
                </tr>

                <tr>
                    <td>Entrega do TC na Coordenação?</td>
                    <td>
                        <?php
                        switch ($estagio['Estagiario']['tc']) {
                            case 0: echo "Não";
                                break;
                            case 1: echo "Sim";
                                break;
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Professor</td>
                    <td><?php echo $estagio['Professor']['nome']; ?></td>
                </tr>

                <tr>
                    <td>Área temática</td>
                    <td><?php echo $estagio['Areaestagio']['area']; ?></td>
                </tr>

                <tr>
                    <td>Instituição</td>
                    <td><?php echo $estagio['Instituicao']['instituicao']; ?></td>
                </tr>

                <tr>
                    <td>Supervisor</td>
                    <td><?php echo $estagio['Supervisor']['nome']; ?></td>
                </tr>

                <tr>
                    <td>Nota</td>
                    <td><?php echo $estagio['Estagiario']['nota']; ?></td>
                </tr>

                <tr>
                    <td>Carga horária</td>
                    <td><?php echo $estagio['Estagiario']['ch']; ?></td>
                </tr>

                <tr>
                    <td>Observações</td>
                    <td><?php echo $estagio['Estagiario']['observacoes']; ?></td>
                </tr>

            </tbody>
        </table>


        <p>
        <nav class="nav nav-pills">
            <?php echo $this->Html->link('Editar', '/Estagiarios/edit/' . $estagio['Estagiario']['id'], ['class' => 'nav-item nav-link']); ?>
            <?php echo $this->Html->link('Inserir estágio', '/Estagiarios/add/' . $estagio['Estagiario']['aluno_id'], ['class' => 'nav-item nav-link']); ?>
            <?php echo $this->Html->link('Listar', '/Estagiarios/index/' . $estagio['Estagiario']['periodo'], ['class' => 'nav-item nav-link']); ?>
        </nav>
        </p>
    </div>

    <div class="tab-pane container fade" id="estagio_historico">
        <?php if ($estagios): ?>
            <table class="table table-striped table-hover table-responsive">
                <caption>Estágios cursados</caption>
                <thead class="thead-light">
                    <tr>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <th>Excluir</th>
                            <th>Editar</th>
                        <?php endif; ?>
                        <th>Ajuste 2020</th>
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
                <tbody>
                    <?php foreach ($estagios as $c_aluno_estagio): ?>
                        <?php // pr($c_aluno_estagio);  ?>
                        <?php // die(); ?>
                        <?php if ($c_aluno_estagio['Estagiario']['nivel'] <= '4'): ?>
                            <tr>

                                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                    <td>
                                        <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_aluno_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_aluno_estagio['Estagiario']['id']); ?>
                                    </td>
                                <?php endif; ?>
                                <td><?php echo $c_aluno_estagio['Estagiario']['ajustecurricular2020'] ?></td>
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

                        <?php elseif ($c_aluno_estagio['Estagiario']['nivel'] > '4'): ?>
                            <tr>
                                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                    <td>
                                        <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_aluno_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_aluno_estagio['Estagiario']['id']); ?>
                                    </td>
                                <?php endif; ?>
                                <td><?php echo $c_aluno_estagio['Estagiario']['ajustecurricular2020'] ?></td>
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
                        <?php else: ?>
                        <h5>Sem estágios</h5>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        <?php else: ?>
            <p>Sem estágios</p>
        <?php endif; ?>
    </div>

    <div class="tab-pane container fade" id="dados_pessoais">
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <td style='text-align:left'>Registro: <?php echo $estagios[array_key_first($estagios)]['Estudante']['registro']; ?></td>
                <td style='text-align:left'>CPF: <?php echo $estagios[array_key_first($estagios)]['Estudante']['cpf']; ?></td>
                <td style='text-align:left'>Cartera de identidade: <?php echo $estagios[array_key_first($estagios)]['Estudante']['identidade']; ?></td>
                <td style='text-align:left'>Orgão: <?php echo $estagios[array_key_first($estagios)]['Estudante']['orgao']; ?></td>
            </tr>
            <tr style='text-align:left'>
                <td style='text-align:left'>Nascimento: <?php echo date('d-m-Y', strtotime($estagios[array_key_first($estagios)]['Estudante']['nascimento'])); ?></td>
                <td style='text-align:left'>Email: <?php echo $estagios[array_key_first($estagios)]['Estudante']['email']; ?></td>
                <td style='text-align:left'>Telefone: <?php echo "(" . $estagios[array_key_first($estagios)]['Estudante']['codigo_telefone'] . ")" . $estagios[array_key_first($estagios)]['Estudante']['telefone']; ?></td>
                <td style='text-align:left'>Celular: <?php echo "(" . $estagios[array_key_first($estagios)]['Estudante']['codigo_celular'] . ")" . $estagios[array_key_first($estagios)]['Estudante']['celular']; ?></td>
            </tr>
            <tr>
                <td style='text-align:left'>Endereço: <?php echo $estagios[array_key_first($estagios)]['Estudante']['endereco']; ?></td>
                <td style='text-align:left'>CEP: <?php echo $estagios[array_key_first($estagios)]['Estudante']['cep']; ?></td>
                <td style='text-align:left'>Bairro: <?php echo $estagios[array_key_first($estagios)]['Estudante']['bairro']; ?></td>
                <td style='text-align:left'>Municipio: <?php echo $estagios[array_key_first($estagios)]['Estudante']['municipio']; ?></td>
            </tr>
        </table>

        <hr/>

        <div class="nav nav-tabs" id="menu-interior">
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <?php echo $this->Html->link('Excluir', '/Estudantes/delete/' . $estagios[array_key_first($estagios)]['Estudante']['id'], ['class' => 'nav-item nav-link'], 'Tem certeza?'); ?>
                <?php echo $this->Html->link('Editar', '/Estudantes/edit/' . $estagios[array_key_first($estagios)]['Estudante']['id'], ['class' => 'nav-item nav-link']); ?>
            <?php endif; ?>
            <hr/>
            <?php if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero') === $estagios[array_key_first($estagios)]['Estudante']['registro'])): ?>
                <p>
                    <?php echo $this->Html->link('Editar', '/Estudantes/edit/' . $estagios[array_key_first($estagios)]['Estudante']['id'], ['class' => 'nav-item nav-link']); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>