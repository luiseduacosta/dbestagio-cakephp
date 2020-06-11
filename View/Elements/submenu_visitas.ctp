<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs">
            <?php
            echo $this->Html->link('Lista', '/visitas/index/', ['class' => 'nav-link']);
            echo $this->Html->link('Instituições', '/Instituicoes/lista/', ['class' => 'nav-link']);
            ?>
        <?php else: ?>
            <?php
            echo $this->Html->link('Lista', '/Visitas/index/', ['class' => 'nav-link']);
            echo $this->Html->link('Instituições', '/Instituicoes/lista/', ['class' => 'nav-link']);
            ?>
        </nav>
    <?php endif; ?>
</div>
