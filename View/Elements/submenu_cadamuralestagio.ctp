<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <nav class="nav nav-tabs nav-justified">
            <?php
            echo $this->Html->link('Excluir mural', '/Muralestagios/delete/' . $mural['Muralestagio']['id'], ['class' => 'nav-link'], 'Tem certeza?');
            echo $this->Html->link('Editar mural', '/Muralestagios/edit/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
            echo $this->Html->link('Listar mural', '/Muralestagios/index/', ['class' => 'nav-link']);
            echo $this->Html->link('Listar inscritos', '/Inscricoes/index/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
            echo $this->Html->link('Imprimir cartaz', '/Muralestagios/publicacartaz/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
            echo $this->Html->link('Publicar no Google', '/Muralestagios/publicagoogle/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
            echo $this->Html->link('Enviar inscrições por email', '/Inscricoes/emailparainstituicao/' . $mural['Muralestagio']['id'], ['class' => 'nav-link']);
            ?>
        </nav>            
    <?php else: ?>
        <nav class="nav nav-tabs nav-justified">
            <?php
            echo $this->Html->link('Listar mural', '/Muralestagios/index/', ['class' => 'nav-link']);
            ?>
        </nav>
    <?php endif; ?>
</div>
