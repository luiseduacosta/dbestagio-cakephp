<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
            <div class='container'>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAreainstituicoes">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class='collapse navbar-collapse' id='navbarAreainstituicoes'>

                    <?php
                    echo $this->Html->link('Instituições', '/Instituicoes/index/', ['class' => 'nav-link']);
                    echo $this->Html->link('Listar áreas', '/Areainstituicoes/index/', ['class' => 'nav-link']);
                    echo $this->Html->link('Inserir', '/Areainstituicoes/add/', ['class' => 'nav-link']);
                    ?>
                <?php else: ?>
                    <?php
                    echo $this->Html->link('Listar', '/Areainstituicoes/index/', ['class' => 'nav-link']);
                    ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>
</div>
