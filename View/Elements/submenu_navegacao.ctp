<nav class='navbar navbar-expand-lg navbar-light bg-success fixed-top'>
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
                    <?php echo $this->Html->link("Termo de compromisso", "/Muralinscricoes/termosolicita", ['class' => 'dropdown-item']); ?>
                    <?php echo $this->Html->link("Avaliação discente", "/Estudantes/avaliacaosolicita", ['class' => 'dropdown-item']); ?>
                    <?php echo $this->Html->link("Folha de atividades", "/Estudantes/folhadeatividades", ['class' => 'dropdown-item']); ?>
                    <?php echo $this->Html->link("Declaração de estágio", "/Estudantes/busca_dre", ['class' => 'dropdown-item']); ?>
                </div>
            </li>

            <?php if ($this->Session->read('categoria')): ?>
                <li class="nav-item">
                    <?php echo $this->Html->link("Estagiários", "/Estagiarios/index", ['class' => 'nav-link']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Instituições", "/Instituicaoestagios/lista", ['escape' => FALSE, 'class' => 'nav-link']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Supervisores", "/Supervisores/index/ordem:nome", ['class' => 'nav-link']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Professores", "/Professores/index/", ['class' => 'nav-link']); ?>
                </li>
            <?php endif; ?>

            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                    <div class="dropdown-menu">
                        <?php echo $this->Html->link('Configuração', '/configuracaos/view/1', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Usuários', '/Userestagios/listausuarios/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Planilha seguro', '/Estudantes/planilhaseguro/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Planilha CRESS', '/Estudantes/planilhacress/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Carga horária', '/Estudantes/cargahoraria/', ['class' => 'dropdown-item']); ?>
                    </div>
                </li>
            <?php endif; ?>

            <li class = "nav-item">
                <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link']); ?>
            </li>
            <li class = "nav-item">
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link']); ?>
            </li>
        </ul>
        <ul class = "navbar-nav ml-auto">
            <?php
            switch ($this->Session->read('id_categoria')) {
                case 1: // Administrador
                    ?>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                case 2: // Estudante
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Estudantes/view/registro:" . $this->Session->read('numero'), ['class' => 'nav-link']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                case 3: // Professor
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Professores/view/siape:" . $this->Session->read('numero'), ['class' => 'nav-link']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                case 4: // Supervisor
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Supervisores/view/cress:" . $this->Session->read('numero'), ['class' => 'nav-link']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                default:
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Login", ['controller' => 'Userestagios', 'action' => 'login'], ['class' => 'nav-link']); ?>
                    </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>
