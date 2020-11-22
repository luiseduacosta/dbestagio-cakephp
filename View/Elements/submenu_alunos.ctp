<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
            <div class='container'>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAlunos">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class='collapse navbar-collapse' id='navbarAlunos'>

                    <?php echo $this->Html->link('Estagiários', '/Estagiarios/index', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Listar estudantes', '/Alunos/index/', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Inserir estudante', '/alunos/add', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por Nome', '/Alunos/busca', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por DRE', '/Alunos/busca_dre', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por Email', '/Alunos/busca_email', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por CPF', '/Alunos/busca_cpf', ['class' => 'nav-link']); ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>
</div>
