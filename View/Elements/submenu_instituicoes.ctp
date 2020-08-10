<div class="submenusuperior">
    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <div class='container'>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarInstituicoes">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarInstituicoes'>

                <?php if ($this->Session->read('categoria') === 'administrador'): ?>

                    <?php
                    echo $this->Html->link('Inserir', '/Instituicaoestagios/add/', ['class' => 'nav-item nav-link']);
                    echo $this->Html->link('Buscar', '/Instituicaoestagios/busca/', ['class' => 'nav-item nav-link']);
                    echo $this->Html->link('Área', '/Areainstituicaoestagios/index/', ['class' => 'nav-item nav-link']);
                    echo $this->Html->link('Natureza', '/Instituicaoestagios/natureza/', ['class' => 'nav-item nav-link']);
                    echo $this->Html->link('Lista', '/Instituicaoestagios/lista/', ['class' => 'nav-item nav-link']);
                    echo $this->Html->link('Outra lista', '/Instituicaoestagios/index1/', ['class' => 'nav-item nav-link']);
                    echo $this->Html->link('Visitas', '/Visitas/index/', ['class' => 'nav-item nav-link']);
                    ?>
                <?php else: ?>
                    <?php
                    echo $this->Html->link('Buscar', '/Instituicaoestagios/busca/', ['class' => 'nav-item nav-link']);
                    echo $this->Html->link('Lista', '/Instituicaoestagios/lista/', ['class' => 'nav-item nav-link']);
                    ?>

                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>
