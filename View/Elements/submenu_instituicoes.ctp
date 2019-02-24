<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Inserir','/Instituicaos/add/');
    echo " | ";
    echo $this->Html->link('Buscar','/Instituicaos/busca/');
    echo " || ";
    echo $this->Html->link('Área','/Areainstituicaos/index/');
    echo " | ";
    echo $this->Html->link('Natureza','/Instituicaos/natureza/');
    echo " | ";
    echo $this->Html->link('Lista','/instituicaos/lista/');
    ?>
<?php else: ?>
    <?php
    echo $this->Html->link('Buscar','/Instituicaos/busca/');
    echo " | ";    
    echo $this->Html->link('Lista','/instituicaos/lista/');
    ?>
<?php endif; ?>
</div>
