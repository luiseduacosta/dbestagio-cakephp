<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
    <div class='container'>

        <?php echo $this->Html->link("ESS", "http://www.ess.ufrj.br", ['class' => 'navbar-brand']); ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMural">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class='collapse navbar-collapse' id='navbarMural'>
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <?php echo $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link']); ?>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Documentação</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php echo $this->Html->link("Termo de compromisso", "/Inscricoes/termosolicita", ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Avaliação discente", "/Alunos/avaliacaosolicita", ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Folha de atividades", "/Alunos/folhadeatividades", ['class' => 'dropdown-item']); ?>
                    </div>
                </li>

                <?php if ($this->Session->read('categoria')): ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Estagiários", "/Estagiarios/index", ['class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Instituições", "/Instituicoes/lista", ['escape' => FALSE, 'class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Supervisores", "/Supervisores/index/ordem:nome", ['class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Professores", "/Professores/index", ['class' => 'nav-link']); ?>
                    </li>
                <?php endif; ?>

                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                        <div class="dropdown-menu">
                            <?php echo $this->Html->link('Configuração', '/configuracaos/view/1', ['class' => 'dropdown-item']); ?>
                            <?php echo $this->Html->link('Usuários', '/Userestagios/listausuarios/', ['class' => 'dropdown-item']); ?>
                            <?php echo $this->Html->link('Planilha seguro', '/alunos/planilhaseguro/', ['class' => 'dropdown-item']); ?>
                            <?php echo $this->Html->link('Planilha CRESS', '/alunos/planilhacress/', ['class' => 'dropdown-item']); ?>
                            <?php echo $this->Html->link('Carga horária', '/alunos/cargahoraria/', ['class' => 'dropdown-item']); ?>
                        </div>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link']); ?>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php echo $this->Html->link("Login", ['controller' => 'Userestagios', 'action' => 'login'], ['class' => 'nav-link']); ?>
                    <!--
                    <a class="nav-link" href="<?= $this->Html->url(['controller' => 'Userestagios', 'action' => 'login']); ?>">Login <span class="sr-only">(current)</span></a>
                    -->
                </li>

                <?php if ($this->Session->read('user')): ?>
                    <?php echo "<span style='color: white; font-weight: bold; text-transform: capitalize'>" . $this->Session->read('categoria') . "</span>" . ": "; ?>

                    <?php
                    switch ($this->Session->read('menu_aluno')) {
                        case 'estagiario':
                            // echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/Estudantes/view/" . $this->Session->read('numero')) . "</span>" . " ";
                            break;
                        case 'alunonovo':
                            // echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/Estudantes/view/" . $this->Session->read('numero')) . "</span>" . " ";
                            break;
                        case 'semcadastro':
                            // echo "<span style='color: white; font-weight: bold'>" . $this->Session->read('user') . "</span>" . " ";
                            break;
                    }
                    if ($this->Session->read('menu_supervisor_id'))
                    // echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/Supervisores/view/" . $this->Session->read('menu_supervisor_id')) . "</span>" . " ";
                        
                        ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link']); ?>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>



