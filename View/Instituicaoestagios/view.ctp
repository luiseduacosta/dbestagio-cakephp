<?php // pr($instituicao);                  ?>

<?php echo $this->element('submenu_instituicoes'); ?>

<div class='container'>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active btn-light" data-toggle="pill" href="#dados_instituicao">Instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-light" data-toggle="pill" href="#dados_supervisores">Supervisores</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-light" data-toggle="pill" href="#dados_estagiarios">Estagiários</a>
        </li>
    </ul>
</div>

<div class='tab-content'>
    <div class="tab-pane container active" id="dados_instituicao">'

        <div align="center">
            <?php echo $this->Html->link('Retroceder', array('url' => 'view', $registro_prev)) . " "; ?> |
            <?php echo $this->Html->link('Avançar', array('url' => 'view', $registro_next)); ?>
        </div>
        <br>
        <div class='row'>
            <div class='col-3'>
                <p>Instituição</p>
            </div>
            <div class='col'>
                <p><?= $this->Html->link($instituicao['Instituicaoestagio']['instituicao'], '/Estagiarios/index/instituicao_id:' . $instituicao['Instituicaoestagio']['id']); ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>CNPJ</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['cnpj']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Email</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['email']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Página web</p>
            </div>
            <div class='col'>
                <p><?= $this->Html->link($instituicao['Instituicaoestagio']['url'], $instituicao['Instituicaoestagio']['url']); ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Convênio com a UFRJ</p>
            </div>
            <div class='col'>
                <p>
                    <?php
                    if (!empty($instituicao['Instituicaoestagio']['convenio'])) {
                        echo $this->Html->link($instituicao['Instituicaoestagio']['convenio'], "http://www.pr1.ufrj.br/estagios/info.php?codEmpresa=" . $instituicao['Instituicaoestagio']['convenio']);
                    } else {
                        echo "Sem dados";
                    }
                    ?>
                </p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Data de expiração do convênio</p>
            </div>
            <div class='col'>
                <p>
                    <?php
                    if (!empty($instituicao['Instituicaoestagio']['expira'])) {
                        echo date('d-m-Y', strtotime($instituicao['Instituicaoestagio']['expira']));
                    } else {
                        echo "Sem dados";
                    }
                    ?>
                </p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Seguro</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['seguro']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Visita</p>
            </div>
            <div class='col'>
                <p>
                    <?php
                    /* PHP 7.2 */
                    $visitas = (is_array($instituicao['Visita']) ? sizeof($instituicao['Visita']) : 0);
                    /* PHP 7.2 */
                    if ($visitas > 0):
                        $ultimavisita = end($instituicao['Visita']);
                        if ($ultimavisita['data']):
                            echo $this->Html->link(date('d-m-Y', strtotime($ultimavisita['data'])), '/Visitas/view/' . $ultimavisita['id']);
                        else:
                            echo "Sem visita";
                        endif;
                    else:
                        echo "Sem visita";
                    endif;
                    ?>
                </p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Área da instituição</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Areainstituicao']['area']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Natureza</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['natureza']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Endereço</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['endereco']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>CEP</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['cep']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Bairro</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['bairro']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Município</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['municipio']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Telefone</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['telefone']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Fax</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['fax']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Benefícios</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['beneficio']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Final de semana</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['fim_de_semana']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-3'>
                <p>Observações</p>
            </div>
            <div class='col'>
                <p><?php echo $instituicao['Instituicaoestagio']['observacoes']; ?></p>
            </div>
        </div>


        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <nav class="nav nav-tabs">
                <?php echo $this->Html->link('Excluir', '/Instituicaoestagios/delete/' . $instituicao['Instituicaoestagio']['id'], ['class' => 'nav-list nav-link'], 'Tem certeza?'); ?>
                <?php echo $this->Html->link('Editar', '/Instituicaoestagios/edit/' . $instituicao['Instituicaoestagio']['id'], ['class' => 'nav-list nav-link']); ?>
            </nav>
        <?php endif; ?>

    </div>

    <div class="tab-pane container fade" id='dados_supervisores'>

        <?php
// pr($instituicao['Supervisor']);

        if ($instituicao['Supervisor']) {
            $i = 0;
            foreach ($instituicao['Supervisor'] as $c_supervisor) {
                $cada_supervisor[$i]['nome'] = $c_supervisor['nome'];
                $cada_supervisor[$i]['id'] = $c_supervisor['id'];
                $cada_supervisor[$i]['cress'] = $c_supervisor['cress'];
                $cada_supervisor[$i]['id_superinst'] = $c_supervisor['InstituicaoestagioSupervisor']['id'];
                $i++;
            }
            sort($cada_supervisor);
        }
        ?>

        <?php if (isset($cada_supervisor)): ?>

            <br />
            <h5>Supervisores</h5>

            <table class='table table-striped table-hover table-responsive'>
                <caption>Supervisores</caption>
                <thead class='thead-light'>
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
                                echo $this->Html->link($c_supervisor['nome'], '/Supervisores/view/' . $c_supervisor['id']);
                                ?>
                            </td>

                            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                <td>
                                    <?php
                                    echo $this->Html->link('Excluir', '/Instituicaoestagios/deleteassociacao/' . $c_supervisor['id_superinst'], null, 'Tem certeza?');
                                    ?>
                                </td>
                            <?php endif; ?>

                        </tr>
                    </tbody>
                <?php endforeach; ?>
                <tfoot>

                </tfoot>
            </table>

        <?php endif; ?>

        <hr />

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>

            <h5>Inserir supervisor</h5>

            <?php
            echo $this->Form->create('Instituicaoestagio', array('controller' => 'Instituicaoestagios', 'url' => 'addassociacao'));
            echo $this->Form->input('InstituicaoestagioSupervisor.instituicaoestagio_id', array('type' => 'hidden', 'value' => $instituicao['Instituicaoestagio']['id']));
            echo $this->Form->input('InstituicaoestagioSupervisor.supervisor_id', array('label' => 'Supervisor', 'options' => $supervisores, 'default' => 0, 'empty' => 'Seleciona', 'class' => 'form-control'));
            ?>
            <br>
            <?php
            echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']);
            echo $this->Form->end();
            ?>

        <?php endif; ?>
    </div>
    <?php
    // pr($estudantes);
    // die('estudantes');
    ?>
    <div class="tab-pane container fade" id="dados_estagiarios">

        <h5>Estagiários</h5>

        <?php if (!empty($estudantes)): ?>

            <?php foreach ($estudantes as $c_estagiario): ?>
                <div class='row'>
                    <div class='col-2'>
                        <p><?php echo $c_estagiario['registro']; ?></p>
                    </div>
                    <div class='col-8'>
                        <p><?php echo $this->Html->link($c_estagiario['nome'], '/Estudantes/view/' . $c_estagiario['registro']); ?></p>
                    </div>
                    <div class='col-2'>
                        <p><?php echo $c_estagiario['periodo']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>

            <h5>Instituição sem estagiários</h5>

        <?php endif; ?>
    </div>
</div>