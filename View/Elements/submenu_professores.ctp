<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs">
            <?php
            echo $this->Html->link('Inserir', '/Professores/add/', ['class' => 'nav-item nav-link']);
            // echo $this->Html->link('Buscar (não implementado)', '/Professores/busca/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Áreas', '/Areaestagios/index/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Pauta', '/Professores/pauta/', ['class' => 'nav-item nav-link']);
            ?>
            <?= $this->Html->link('Listar', '/Professores/index/', ['class' => 'nav-item nav-link']); ?>
        <?php else: ?>
            <?php
            // echo $this->Html->link('Buscar (não implementado)', '/Professores/busca/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Áreas', '/Areaestagios/index/', ['class' => 'nav-item nav-link']);
            echo $this->Html->link('Pauta', '/Professores/pauta/', ['class' => 'nav-item nav-link']);
            ?>
        <?= $this->Html->link('Listar', '/Professores/index/', ['class' => 'nav-item nav-link']); ?>
        </nav>
<?php endif; ?>
</div>
