<?php // pr($mural);         ?>

<?= $this->element('submenu_cadamuralestagio'); ?>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <div class='table-responsive'>
            <table class="table table-striped table-hover table-responsive">
                <thead class="thead-light">
                    <tr>
                        <th colspan="2" style="text-align: center"><?php echo $mural['Muralestagio']['instituicao']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Instituição</td>
                        <td><?php echo $mural['Muralestagio']['instituicao']; ?></td>
                    </tr>

                    <tr>
                        <td>Convênio</td>
                        <td>
                            <?php
                            switch ($mural['Muralestagio']['convenio']) {
                                case 0: $convenio = 'Não';
                                    break;
                                case 1: $convenio = 'Sim';
                                    break;
                            }
                            echo $convenio;
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Período</td>
                        <td><?php echo $mural['Muralestagio']['periodo']; ?></td>
                    </tr>

                    <tr>
                        <td>Vagas</td>
                        <td><?php echo $mural['Muralestagio']['vagas']; ?></td>
                    </tr>

                    <tr>
                        <td>Benefícios</td>
                        <td><?php echo $mural['Muralestagio']['beneficios']; ?></td>
                    </tr>

                    <tr>
                        <td>Final de semana</td>
                        <td>
                            <?php
                            switch ($mural['Muralestagio']['final_de_semana']) {
                                case 0: $final_de_semana = 'Não';
                                    break;
                                case 1: $final_de_semana = 'Sim';
                                    break;
                                case 2: $final_de_semana = 'Parcialmente';
                                    break;
                            }
                            echo $final_de_semana;
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Carga horária</td>
                        <td><?php echo $mural['Muralestagio']['cargaHoraria']; ?></td>
                    </tr>

                    <tr>
                        <td>Requisitos</td>
                        <td><?php echo $mural['Muralestagio']['requisitos']; ?></td>
                    </tr>

                    <tr>
                        <td>Área de OTP</td>
                        <td><?php echo $mural['Areaestagio']['area']; ?></td>
                    </tr>

                    <tr>
                        <td>Professor</td>
                        <td><?php echo $mural['Professor']['nome']; ?></td>
                    </tr>

                    <tr>
                        <td>Horário do estágio</td>
                        <td>
                            <?php
                            switch ($mural['Muralestagio']['horario']) {
                                case 'D': $horario = 'Diurno';
                                    break;
                                case 'N': $horario = 'Noturno';
                                    break;
                                case 'A': $horario = 'Ambos';
                                    break;
                            }
                            echo $horario;
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Inscrições até o dia: </td>
                        <td><?php echo date('d-m-Y', strtotime($mural['Muralestagio']['dataInscricao'])); ?></td>
                    </tr>

                    <tr>
                        <td>Data da seleção</td>
                        <td><?php echo date('d-m-Y', strtotime($mural['Muralestagio']['dataSelecao'])) . " Horário: " . $mural['Muralestagio']['horarioSelecao']; ?></td>
                    </tr>

                    <tr>
                        <td>Local da seleção</td>
                        <td><?php echo $mural['Muralestagio']['localSelecao']; ?></td>
                    </tr>

                    <tr>
                        <td>Forma de seleção</td>
                        <td>
                            <?php
                            switch ($mural['Muralestagio']['formaSelecao']) {
                                case 0: $formaselecao = 'Entrevista';
                                    break;
                                case 1: $formaselecao = 'CR';
                                    break;
                                case 2: $formaselecao = 'Prova';
                                    break;
                                case 3: $formaselecao = 'Outra';
                                    break;
                            }
                            echo $formaselecao;
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Contatos</td>
                        <td><?php echo $mural['Muralestagio']['contato']; ?></td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td><?php echo $mural['Muralestagio']['email']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Email enviado (preenchimento automático)</td>
                        <td><?php
                            if ($mural['Muralestagio']['datafax']) {
                                echo date('d-m-Y', strtotime($mural['Muralestagio']['datafax']));
                            } else {
                                echo "Email não enviado";
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Local de Inscrição</td>
                        <td>
                            <?php
                            if (($mural['Muralestagio']['localInscricao']) == 0) {
                                echo "Inscrição no mural da Coordenação de Estágio e Extensão da ESS";
                            } elseif (($mural['Muralestagio']['localInscricao']) == 1) {
                                echo "Inscrição diretamente na Instituição e no mural da Coordenação de Estágio e Extensão da ESS";
                            }
                            ?></td>
                    </tr>


                    <tr>
                        <td>Observações</td>
                        <td><?php echo $mural['Muralestagio']['outras']; ?></td>
                    </tr>

                    <!--
                    Se a inscricao e na instituição também tem que fazer inscrição no mural
                    //-->
                    <?php if ($mural['Muralestagio']['localInscricao'] === '1'): ?>

                        <tr>
                            <td colspan = 2>
                                <p style="text-align: center; color: red">Não esqueça de também fazer inscrição diretamente na instituição. Ambas são necessárias!</p>
                            </td>
                        </tr>

                    <?php endif; ?>

                    <!--
                    Para o administrador as inscrições sempre estão abertas
                    //-->
                    <?php if ($this->Session->read('id_categoria') === '1'): ?>
                        <tr>
                            <td colspan = 2 style="text-align: center">
                                <a href="<?= $this->Html->url(['controller' => 'Muralinscricoes', 'action' => 'add/registro:' . $this->Session->read('numero') . '/muralestagio_id:' . $mural['Muralestagio']['id']]); ?>" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Inscrição</a>
                            </td>
                        </tr>

                    <?php elseif ($this->Session->read('id_categoria') === '2'): ?>

                        <!--
                        Para os estudantes as inscrições dependem da data de encerramento
                        //-->
                        <?php if (date('Y-m-d') < $mural['Muralestagio']['dataInscricao']): ?>
                            <tr>
                                <td colspan = 2 style="text-align: center">
                                    <a href="<?= $this->Html->url(['controller' => 'Muralinscricoes', 'action' => 'add/registro:' . $this->Session->read('numero') . '/muralestagio_id:' . $mural['Muralestagio']['id']]); ?>" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Inscrição</a>
                                </td>                  
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan = 2 style="text-align: center">
                                    <a href="#" class="btn btn-dark btn-lg active" role="button" aria-pressed="true">Inscrições encerradas!</a>
                                </td>
                            </tr>
                        <?php endif; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan = 2 style="text-align: center">
                                <a href="#" class="btn btn-light btn-lg active" role="button" aria-pressed="true">Somente para usuários cadastrados</a>
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>