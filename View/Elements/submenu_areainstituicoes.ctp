<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs">
            <?php
            echo $this->Html->link('Instituições', '/Instituicoes/index/', ['class' => 'nav-link']);
            echo $this->Html->link('Listar áreas', '/Areainstituicoes/index/', ['class' => 'nav-link']);
            echo $this->Html->link('Inserir', '/Areainstituicoes/add/', ['class' => 'nav-link']);
            ?>
        <?php else: ?>
            <?php
            echo $this->Html->link('Listar', '/Areainstituicoes/index/', ['class' => 'nav-link']);
            ?>
        </nav>
    <?php endif; ?>
</div>
