<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class='nav nav-tabs'>
            <?php
            echo $this->Html->link('Inserir', '/Instituicoes/add/', ['class' => 'nav-link']);
            echo $this->Html->link('Buscar', '/Instituicoes/busca/', ['class' => 'nav-link']);
            echo $this->Html->link('Área', '/Areainstituicoes/index/', ['class' => 'nav-link']);
            echo $this->Html->link('Natureza', '/Instituicoes/natureza/', ['class' => 'nav-link']);
            echo $this->Html->link('Lista', '/Instituicoes/lista/', ['class' => 'nav-link']);
            echo $this->Html->link('Outra lista', '/Instituicoes/index1/', ['class' => 'nav-link']);
            echo $this->Html->link('Visitas', '/Visitas/index/', ['class' => 'nav-link']);
            ?>
        <?php else: ?>
            <?php
            echo $this->Html->link('Buscar', '/Instituicoes/busca/', ['class' => 'nav-link']);
            echo $this->Html->link('Lista', '/Instituicoes/lista/', ['class' => 'nav-link']);
            ?>
        </nav>
    <?php endif; ?>
</div>
