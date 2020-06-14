<div class="container">
    <div class="row">
        <div class='col-lg-6 order-lg-1 order-2'>
            <?= $this->Form->create('Userestagio'); ?>
            <div class="form-group">
                <?= $this->Form->input('email', ['label' => 'Email', 'type' => 'text', 'class' => 'form-control']); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->input('password', ['label' => 'Senha', 'class' => 'form-control']); ?>
            </div>
            <?= $this->Form->end('Login'); ?>
            <div class="nav nav-tabs justify-content-center">
                <?= $this->Html->link('Esqueceu a senha?', '/users/cadastro/', ['class' => ['nav-item', 'nav-link']]); ?>
                <?= $this->Html->link('Fazer cadastro', '/users/cadastro/', ['class' => ['nav-item', 'nav-link']]); ?>
            </div>
        </div>
        <div class='col-lg-6 order-lg-2 order-1'>
            <p>
                Prezadas(os) usuárias(os),
                <br />
                <br />
                Para fazer inscrição para seleção de estágio, assim como também para solicitar o termo de compromisso, é necessário estar <?php echo $this->Html->link('cadastrado', '/users/cadastro/'); ?> como usuária(o) do sistema.
                <br />
                <br />
                As(os) estudantes cadastrados poderão, além de fazer inscrição para seleção de estágio, solicitar <?php echo $this->Html->link('termo de compromisso', '/inscricaos/termosolicita/'); ?>, formulário de <?php echo $this->Html->link('avaliação discente', '/alunos/avaliacaosolicita/'); ?> de parte do supervisor, atualizar a informação sobre seus dados pessoais, assim como também, atualizar informação sobre as instituições campos de estágio da ESS/UFRJ.
                <br />
                <br />
                Supervisores e professores também podem realizar cadastro, e contribuir para atualizar dados das instituições, assim como manter atualizada a informação sobre seus dados profissionais.
                <br />
                <br />
                Agora também está disponível para <i>download</i> a <strong>Folha de atividades!</p>
            <br />
            <br />
            <p style="text-align: right">Coordenação de Estágio & Extensão</p>
        </div>
    </div>
</div>