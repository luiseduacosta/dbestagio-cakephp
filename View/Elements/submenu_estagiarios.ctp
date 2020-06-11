<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs">
            <?php echo $this->Html->link('Estudantes', '/Estudantes/index', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link("Inserir estagiário", "/Estagiarios/add_estagiario", ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link("Busca estudante", "/Alunos/busca", ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Estágio não obrigatório', '/Estagiarios/index/nivel:' . 9, ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Estagiários sem estágio', '/Estagiarios/alunorfao', ['class' => 'nav-link']); ?>
        </nav>
    <?php endif; ?>
</div>
