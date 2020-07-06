<div class="submenusuperior">
    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <div class='container'>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMuralestagio">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarMuralestagio'>
                
                <?= $this->Html->link('Listar mural', '/Muralestagios/index/', ['class' => 'nav-item nav-link ative']); ?>
                <?= $this->Html->link('Inserir mural', '/Muralestagios/add/', ['class' => 'nav-item nav-link']); ?>
                <?= $this->Html->link('Listar estudantes', '/Inscricoes/index/', ['class' => 'nav-item nav-link']); ?>
                <?= $this->Html->link('Estudantes sem inscrição', '/Inscricoes/orfao/', ['class' => 'nav-item nav-link']); ?>
            </div>
        </div>
    </nav>            
</div>
