<?php

$this->Session->flash('auth');

echo $this->Form->create('User', array('action'=>'login'));
?>
<table>
    <tr>
        <td width="30%">
        <?php
        echo $this->Form->input('email', array('label'=>'Email', 'type'=>'text', 'size'=>'20'));

        echo $this->Form->input('password');

        echo $this->Form->end('Login');
        ?>
        </td>

        <td style="vertical-align: inherit">
            Prezados usuários,
            <br />
            <br />
            Agora, para fazer inscrição para seleção de estágio, assim como também, para solicitar o termo de compromisso, é necessário estar <?php echo $html->link('cadastrado', '/Users/cadastro/'); ?> como usuário do sistema.
            <br />
            <br />
            Os estudantes cadastrados poderão, além de fazer inscrição para seleção de estágio e solcitar o termo de compromisso, atualizar a informação sobre seus dados pessoais, assim como também poderão, atualizar a informação sobre as instituições campos de estágio da ESS/UFRJ.
            <br />
            <br />
            <p style="text-align: right">Coordenação de Estágio & Extensão</p>
        </td>
    </tr>
</table>

<?php

echo $this->Html->link('Fazer cadastro', '/Users/cadastro/');

?>
