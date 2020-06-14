<?php
$this->Session->flash('auth');
?>
<div class="row">
    <div class='col-lg-6 order-lg-1 order-2'>
        <form class="container">
            <?= $this->Form->create('Userestagio', ['url' => '/Userestagios/login']); ?>
            <div class="form-group">
                <?= $this->Form->input('email', ['label' => 'Email', 'type' => 'text', 'placeholder' => 'e-mail', 'class' => 'form-control']); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->input('password', ['label' => 'Senha', 'type' => 'password', 'class' => 'form-control']); ?>
            </div>
            <?= $this->Form->end('Login'); ?>
        </form>
        <div class="nav nav-tabs justify-content-center">
            <?= $this->Html->link('Esqueceu a senha?', '/Userestagios/cadastro/', ['class' => ['nav-item', 'nav-link']]); ?>
            <?= $this->Html->link('Fazer cadastro', '/Userestagios/cadastro/', ['class' => ['nav-item', 'nav-link']]); ?>
        </div>
    </div>
    <div class='col-lg-6 order-lg-2 order-1'>
        <div class="container">
            <p>Prezadas(os) usuárias(os),
                <br />
                <br />
                Para fazer inscrição para seleção de estágio, assim como também para solicitar o termo de compromisso, é necessário estar <?php echo $this->Html->link('cadastrado', '/Userestagios/cadastro/'); ?> como usuária(o) do sistema.
                <br />
                <br />
                As(os) estudantes cadastrados poderão, além de fazer inscrição para seleção de estágio, solicitar <?php echo $this->Html->link('termo de compromisso', '/Inscricoes/termosolicita/'); ?>, formulário de <?php echo $this->Html->link('avaliação discente', '/Alunos/avaliacaosolicita/'); ?> de parte do supervisor, atualizar a informação sobre seus dados pessoais, assim como também, atualizar informação sobre as instituições campos de estágio da ESS/UFRJ.
                <br />
                <br />
                Supervisores e professores também podem realizar cadastro, e contribuir para atualizar dados das instituições, assim como manter atualizada a informação sobre seus dados profissionais.
                <br />
                <br />
                Agora também está disponível para <i>download</i> a <?= $this->Html->link('Folha de atividades', '/Alunos/folhadeatividades/') ?>.
            </p>
            <br />
            <br />
            <p style="text-align: right">Coordenação de Estágio & Extensão</p>
        </div>
    </div>
</div>