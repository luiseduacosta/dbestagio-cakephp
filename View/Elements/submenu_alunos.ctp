<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs">
            <?php echo $this->Html->link('Estagiários', '/Estagiarios/index', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Listar estudantes', '/Alunos/index/', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Inserir estudante', '/alunos/add', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por Nome', '/Alunos/busca', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por DRE', '/Alunos/busca_dre', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por Email', '/Alunos/busca_email', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Busca por CPF', '/Alunos/busca_cpf', ['class' => 'nav-link']); ?>
        </nav>
    <?php endif; ?>
</div>
