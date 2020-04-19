<?php if ($this->Session->read('categoria') === 'administrador'): ?>

    <?php
    echo $this->Html->link('Excluir mural', '/Murals/delete/' . $mural['Mural']['id'], NULL, 'Tem certeza?');
    echo " | ";
    echo $this->Html->link('Editar mural', '/Murals/edit/' . $mural['Mural']['id']);
    echo " | ";
    echo $this->Html->link('Listar mural', '/Murals/index/');
    echo " | ";
    echo $this->Html->link('Listar inscritos', '/Inscricaos/index/' . $mural['Mural']['id']);
    echo "<br />";
    ?>

    <?php
    echo $this->Html->link('Imprimir cartaz', '/Murals/publicacartaz/' . $mural['Mural']['id']);
    echo " | ";
    echo $this->Html->link('Publicar no Google', '/Murals/publicagoogle/' . $mural['Mural']['id']);
    echo " | ";
    echo $this->Html->link('Enviar inscrições por email', '/Inscricaos/emailparainstituicao/' . $mural['Mural']['id']);
    ?>

<?php endif; ?>

<table>
    <thead>
        <tr>
            <td width="20%"></td>
            <td width="80%"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Instituição</td>
            <td><?php echo $mural['Mural']['instituicao']; ?></td>
        </tr>

        <tr>
            <td>Convênio</td>
            <td>
                <?php
                switch ($mural['Mural']['convenio']) {
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
            <td><?php echo $mural['Mural']['periodo']; ?></td>
        </tr>

        <tr>
            <td>Vagas</td>
            <td><?php echo $mural['Mural']['vagas']; ?></td>
        </tr>

        <tr>
            <td>Benefícios</td>
            <td><?php echo $mural['Mural']['beneficios']; ?></td>
        </tr>

        <tr>
            <td>Final de semana</td>
            <td>
                <?php
                switch ($mural['Mural']['final_de_semana']) {
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
            <td><?php echo $mural['Mural']['cargaHoraria']; ?></td>
        </tr>

        <tr>
            <td>Requisitos</td>
            <td><?php echo $mural['Mural']['requisitos']; ?></td>
        </tr>

        <tr>
            <td>Área de OTP</td>
            <td><?php echo $mural['Area']['area']; ?></td>
        </tr>

        <tr>
            <td>Professor</td>
            <td><?php echo $mural['Professor']['nome']; ?></td>
        </tr>       

        <tr>
            <td>Horário do estágio</td>
            <td>
                <?php
                switch ($mural['Mural']['horario']) {
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
            <td><?php echo date('d-m-Y', strtotime($mural['Mural']['dataInscricao'])); ?></td>
        </tr>

        <tr>
            <td>Data da seleção</td>
            <td><?php echo date('d-m-Y', strtotime($mural['Mural']['dataSelecao'])) . " Horário: " . $mural['Mural']['horarioSelecao']; ?></td>
        </tr>

        <tr>
            <td>Local da seleção</td>
            <td><?php echo $mural['Mural']['localSelecao']; ?></td>
        </tr>

        <tr>
            <td>Forma de seleção</td>
            <td>
                <?php
                switch ($mural['Mural']['formaSelecao']) {
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
            <td><?php echo $mural['Mural']['contato']; ?></td>
        </tr>

        <tr>
            <td>Email</td>
            <td><?php echo $mural['Mural']['email']; ?>
            </td>
        </tr>

        <tr>
            <td>Email enviado (preenchimento automático)</td>
            <td><?php
                if ($mural['Mural']['datafax']) {
                    echo date('d-m-Y', strtotime($mural['Mural']['datafax']));
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
if (($mural['Mural']['localInscricao']) == 0) {
    echo "Inscrição no mural da Coordenação de Estágio e Extensão da ESS";
} elseif (($mural['Mural']['localInscricao']) == 1) {
    echo "Inscrição diretamente na Instituição e no mural da Coordenação de Estágio e Extensão da ESS";
}
?></td>
        </tr>


        <tr>
            <td>Observações</td>
            <td><?php echo $mural['Mural']['outras']; ?></td>
        </tr>

        <!--
        Se a inscricao e na instituição também tem que fazer inscrição no mural
        //-->
        <?php if ($mural['Mural']['localInscricao'] === '1'): ?>

            <tr>
                <td colspan = 2>
                    <p style="text-align: center; color: red">Não esqueça de também fazer inscrição diretamente na instituição. Ambas são necessárias!</p>
                </td>
            </tr>

        <?php endif; ?>        

        <!--
        Para o administrador as inscrições sempre estão abertas
        //-->
<?php if ($this->Session->read('categoria') === 'administrador'): ?>        
            <tr>
                <td colspan = 2 style="text-align: center">
    <?php echo $this->Form->create('Inscricao', array('url' => '/Inscricaos/add/' . $mural['Mural']['id'])); ?>
    <?php echo $this->Form->input('instituicao_id', array('type' => 'hidden', 'value' => $mural['Mural']['id'])); ?>
    <?php echo $this->Form->end('Inscrição'); ?>
                </td>
            </tr>
<?php else: ?>

            <!--
            Para os outros usuários as inscrições dependem da data de encerramento
            //-->

    <?php if (date('Y-m-d') < $mural['Mural']['dataInscricao']): ?> 
                <tr>
                    <td colspan = 2 style="text-align: center">

        <?php echo $this->Form->create('Inscricao', array('url' => '/Inscricaos/add/' . $mural['Mural']['id'])); ?>
        <?php echo $this->Form->input('instituicao_id', array('type' => 'hidden', 'value' => $mural['Mural']['id'])); ?>
        <?php echo $this->Form->end('Inscrição'); ?>
                    </td>
                </tr>
    <?php else: ?>
                <tr>
                    <td colspan = 2>
                        <p style="text-align: center; color: red">Inscrições encerradas!</p>
                    </td>
                </tr>
    <?php endif; ?>

<?php endif; ?>

    </tbody>
</table>
