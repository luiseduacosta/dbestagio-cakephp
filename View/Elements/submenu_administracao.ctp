<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
            <div class='container'>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAdministracao">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class='collapse navbar-collapse' id='navbarAdministracao'>
                    <?php echo $this->Html->link('Configurações', '/Configuracaos/view/1', ['class' => ['nav-item nav-link']]); ?>
                    <?php echo $this->Html->link('Usuários', '/Userestagios/listausuarios/', ['class' => ['nav-item nav-link']]); ?>
                    <?php echo $this->Html->link('Planilha seguro', '/Estudantes/planilhaseguro/', ['class' => ['nav-item nav-link']]); ?>
                    <?php echo $this->Html->link('Planilha CRESS', '/Estudantes/planilhacress/', ['class' => ['nav-item nav-link']]); ?>
                    <?php echo $this->Html->link('Carga horária', '/Estudantes/cargahoraria/', ['class' => ['nav-item nav-link']]); ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>
</div>
