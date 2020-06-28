<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class='nav nav-tabs'>
            <?php
            echo $this->Html->link('Inserir', '/Instituicoes/add/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Buscar', '/Instituicoes/busca/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Área', '/Areainstituicoes/index/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Natureza', '/Instituicoes/natureza/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Lista', '/Instituicoes/lista/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Outra lista', '/Instituicoes/index1/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Visitas', '/Visitas/index/', ['class' => 'nav-item nav-link']);
            ?>
        <?php else: ?>
            <?php
            echo $this->Html->link('Buscar', '/Instituicoes/busca/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Lista', '/Instituicoes/lista/', ['class' => 'nav-item nav-link']);
            ?>
        </nav>
    <?php endif; ?>
</div>
