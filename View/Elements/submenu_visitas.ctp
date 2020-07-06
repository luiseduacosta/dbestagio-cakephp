<div class="submenusuperior">
    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <div class='container'>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarVisitas">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarVisitas'>
                '
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <?php
                    echo $this->Html->link('Lista', '/visitas/index/', ['class' => 'nav-link']);
                    echo $this->Html->link('Instituições', '/Instituicoes/lista/', ['class' => 'nav-link']);
                    ?>
                <?php else: ?>
                    <?php
                    echo $this->Html->link('Lista', '/Visitas/index/', ['class' => 'nav-link']);
                    echo $this->Html->link('Instituições', '/Instituicoes/lista/', ['class' => 'nav-link']);
                    ?>

                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>
