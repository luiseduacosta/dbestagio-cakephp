<div class="submenusuperior">
    <nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
        <div class='container'>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCadamuralestagio">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarCadamuralestagio'>

                <?php if ($this->Session->read('categoria') === 'administrador'): ?>

                    <?php
                    echo $this->Html->link('Excluir mural', '/Muralestagios/delete/' . $mural['Muralestagio']['id'], ['class' => 'nav-link'], 'Tem certeza?');
                    echo $this->Html->link('Editar mural', '/Muralestagios/edit/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
                    echo $this->Html->link('Listar mural', '/Muralestagios/index/', ['class' => 'nav-link']);
                    echo $this->Html->link('Listar inscritos', '/Muralinscricoes/index/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
                    echo $this->Html->link('Imprimir cartaz', '/Muralestagios/publicacartaz/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
                    echo $this->Html->link('Publicar no Google', '/Muralestagios/publicagoogle/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
                    echo $this->Html->link('Enviar inscrições por email', '/Muralinscricoes/emailparainstituicao/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
                    ?>
                <?php else: ?>
                    <?php
                    echo $this->Html->link('Listar mural', '/Muralestagios/index/', ['class' => 'nav-link']);
                    ?>

                <?php endif; ?>
            </div>
        </div>                    
    </nav>

</div>
