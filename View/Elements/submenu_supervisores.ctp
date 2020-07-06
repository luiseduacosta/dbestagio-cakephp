<div class="submenusuperior">
    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <div class='container'>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupervisores">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarSupervisores'>


                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
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

                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>
