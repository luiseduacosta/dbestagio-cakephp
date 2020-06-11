<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <nav class="nav nav-tabs">
        <?php
        echo $this->Html->link('Listar', '/Supervisores/index/', ['class' => 'nav-link']);
        echo $this->Html->link('Inserir', '/Supervisores/add/', ['class' => 'nav-link']);
        echo $this->Html->link('Buscar', '/Supervisores/busca/', ['class' => 'nav-link']);
        echo $this->Html->link('Repetidos', '/Supervisores/repetidos/', ['class' => 'nav-link']);
        echo $this->Html->link('Sem alunos', '/Supervisores/semalunos/', ['class' => 'nav-link']);
        echo $this->Html->link('Sem instituição', '/Supervisores/seminstituicao/', ['class' => 'nav-link']);
        ?>
    <?php else: ?>
        <?php
        echo $this->Html->link('Buscar', '/Supervisores/busca/', ['class' => 'nav-link']);
        ?>
        </nav>
    <?php endif; ?>
</div>
