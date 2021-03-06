<?php

$this->Session->flash('auth');

echo $this->Form->create('Userestagio', array('url' =>'login'));
?>
<table>
    <tr>
        <td width="30%">
        <?php
        echo $this->Form->input('email', array('label'=>'Email', 'type'=>'text', 'size'=>'20'));

        echo $this->Form->input('password', array('label' => 'Senha'));

        echo $this->Form->end('Login');
        ?>
        </td>

        <td style="vertical-align: inherit">
            Prezadas(os) usuárias(os),
            <br />
            <br />
            Para fazer inscrição para seleção de estágio, assim como também para solicitar o termo de compromisso, é necessário estar <?php echo $this->Html->link('cadastrado', '/Userestagios/cadastro/'); ?> como usuária(o) do sistema.
            <br />
            <br />
            As(os) estudantes cadastrados poderão, além de fazer inscrição para seleção de estágio, solicitar <?php echo $this->Html->link('termo de compromisso', '/inscricoes/termosolicita/'); ?>, formulário de <?php echo $this->Html->link('avaliação discente', '/alunos/avaliacaosolicita/'); ?> de parte do supervisor, atualizar a informação sobre seus dados pessoais, assim como também, atualizar informação sobre as instituições campos de estágio da ESS/UFRJ.
            <br />
            <br />
            Supervisores e professores também podem realizar cadastro, e contribuir para atualizar dados das instituições, assim como manter atualizada a informação sobre seus dados profissionais.
            <br />
            <br />
            <blink>Agora também está disponível para <i>download</i> a <strong>Folha de atividades!</blink></span>
            <br />
            <br />
            <p style="text-align: right">Coordenação de Estágio & Extensão</p>
        </td>
    </tr>
</table>

<?php

echo $this->Html->link('Esqueceu a senha?', '/Userestagios/cadastro/');
echo " | ";
echo $this->Html->link('Fazer cadastro', '/Userestagios/cadastro/');

?>
