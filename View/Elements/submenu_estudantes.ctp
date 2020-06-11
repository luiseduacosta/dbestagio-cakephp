<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs">
            <?php echo $this->Html->link('Estagiários', '/Estagiarios/index', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Listar estudantes', '/Estudantes/index/', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Inserir estudante', '/Estudantes/add', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por Nome', '/Estudantes/busca', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por DRE', '/Estudantes/busca_dre', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por Email', '/Estudantes/busca_email', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por CPF', '/Estudantes/busca_cpf', ['class' => 'nav-link']); ?>
        </nav>
    <?php endif; ?>
</div>
