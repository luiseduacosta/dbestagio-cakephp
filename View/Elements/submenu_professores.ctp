<div class="submenusuperior">

    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarProfessores">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarProfessores'>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                <?php echo $this->Html->link('Inserir', '/Professores/add/', ['class' => 'nav-item nav-link']); ?>

                <?php echo $this->Html->link('Buscar', '/Professores/busca/', ['class' => 'nav-item nav-link']); ?>
                <?php echo $this->Html->link('Áreas', '/Areaestagios/index/', ['class' => 'nav-item nav-link']); ?>
                <?php echo $this->Html->link('Pauta', '/Professores/pauta/', ['class' => 'nav-item nav-link']); ?>
                <?= $this->Html->link('Listar', '/Professores/index/', ['class' => 'nav-item nav-link']); ?>
            <?php else: ?>
                <?php echo $this->Html->link('Buscar', '/Professores/busca/', ['class' => 'nav-item nav-link']); ?>
                <?php echo $this->Html->link('Áreas', '/Areaestagios/index/', ['class' => 'nav-item nav-link']); ?>
                <?php echo $this->Html->link('Pauta', '/Professores/pauta/', ['class' => 'nav-item nav-link']); ?>
                <?= $this->Html->link('Listar', '/Professores/index/', ['class' => 'nav-item nav-link']); ?>
            <?php endif; ?>
        </div>
    </nav>

</div>
