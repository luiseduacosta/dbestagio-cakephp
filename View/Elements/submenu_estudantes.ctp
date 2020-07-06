<div class="submenusuperior">
    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <div class='container'>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarEstudantes">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarEstudantes'>

                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <?php echo $this->Html->link('Listar estudantes', '/Estudantes/index/', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Inserir estudante', '/Estudantes/add', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por Nome', '/Estudantes/busca', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por DRE', '/Estudantes/busca_dre', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por Email', '/Estudantes/busca_email', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Busca por CPF', '/Estudantes/busca_cpf', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Estagiários', '/Estagiarios/index', ['class' => 'nav-link']); ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>
