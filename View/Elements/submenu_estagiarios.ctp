<div class="submenusuperior">
    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <div class='container'>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarEstagiarios">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarEstagiarios'>

                <?php if ($this->Session->read('categoria') === 'administrador'): ?>

                    <?php echo $this->Html->link('Estudantes', '/Estudantes/index', ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link("Inserir estagiário", "/Estagiarios/add_estagiario", ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link("Busca estudante", "/Estudantes/busca", ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Estágio não obrigatório', '/Estagiarios/index/nivel:' . 9, ['class' => 'nav-link']); ?>
                    <?php echo $this->Html->link('Estagiários sem estágio', '/Estagiarios/alunorfao', ['class' => 'nav-link']); ?>

                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>
